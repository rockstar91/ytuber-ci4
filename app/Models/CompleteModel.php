<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

use App\Entities\User;
use App\Entities\Task;
use App\Entities\Complete;

class CompleteModel extends Model
{
    protected $table = 'completions';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Complete';
    protected $beforeInsert = [];
    protected $protectFields = false;

    const COMPLETE_OPENED   = 1;
    const COMPLETE_WAITING  = 2;
    const COMPLETE_EXPIRED  = 3;
    const COMPLETE_FINISHED = 4;
    const COMPLETE_FAILED   = 5;
    const COMPLETE_PENALTY  = 6;

    protected $defaultStatus;

    // Время, в течинии которого метка может находиться в ожидании проверки
    protected $completeOpenedTimeout = 300;

    protected $currentTimestamp = null;

    protected $request = null;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        $this->defaultStatus = self::COMPLETE_OPENED;
        $this->currentTimestamp = round(time(), -1);

        parent::__construct($db, $validation);
    }

    /**
     * @param $complete_id
     * @return Complete|null
     */
    public function getCompleteMark($complete_id) : ?Complete
    {
        return $this->find($complete_id);
    }

    /**
     * @param User $user
     * @param Task $task
     * @return int|null
     * @throws \ReflectionException
     */
    public function insertCompleteMark(User $user, Task $task) : ?int
    {
        $this->request = \Config\Services::request();

        // Устанавливаем timeout (задержка перед закрытием окна), если у задачи есть время
        $timeout = $task->extend['time'] ?? 0;

        // Время, до которого задача может быть выполнена ($this->Type->getCompleteWaitingTimeout($task->type_id);)
        $expires = $this->currentTimestamp + $this->completeOpenedTimeout + $timeout;

        // Количество меток об этой задаче (открыто)
        $started = $this->countBy($task->id, self::COMPLETE_OPENED);

        // Количество возможных выполнений задачи (по бюджету)
        $completionsRemain = floor($task->total_cost / $task->action_cost);

        // Не хватит бюджета на всех
        if ($started >= $completionsRemain) {
            return false;
        }

        // Не хватит лимита в час на всех
        if ($task->hour_limit > 0 && ($task->hour_done + $started) >= $task->hour_limit) {
            return false;
        }

        // Удаление истекших меток (COMPLETE_OPENED)
        $this->removeExpired(self::COMPLETE_OPENED);

        // Удаление метки по этой задаче этого же пользователя
        $this->where('user_id', $user->id)
            ->where('task_id', $task->id)
            ->where('type_id', $task->type_id)
            ->delete();

        // Detect domain code
        $domain = $this->request->uri->getHost() == 'ytubey.com' ? DOMAIN_YTUBEY : DOMAIN_YTUBER;

        // add new
        $data = [
            'user_id' => $user->id,
            'task_id' => $task->id,
            'type_id' => $task->type_id,
            //'account_id'    => (int) $account_id,
            'ip_bin' => inet_pton($this->request->getIPAddress()),
            'action_cost' => $task->action_cost,
            //'cost_rule' => (int)$cost_rule,
            'time' => $this->currentTimestamp,
            'expires' => (int)$expires,
            'timeout' => (int)$timeout,
            //'data' => (int)$data,
            'domain' => $domain,
            'status' => $this->defaultStatus
        ];

        return $this->insert($data); // inserted id or null
    }


    /**
     * @param int $task_id
     * @param int $status
     * @return int|null
     */
    public function countBy(int $task_id, int $status = self::COMPLETE_OPENED, $withExpired = false) : ?int
    {
        $this->where('task_id', $task_id)
            ->where('status', $status);

        if( ! $withExpired )
            $this->where('expires >', $this->currentTimestamp);

        return $this->countAllResults();
    }

    function countFinishedByUser($userId, $offset = 0, $groupBy = 'type_id')
    {
        $this->select('COUNT(id) as total, type_id')
            ->where('user_id', (int) $userId);

        $timestamp = time() - $offset;

        return $this->where('time >', $timestamp)
            ->where('status', self::COMPLETE_FINISHED)
            ->groupBy($groupBy)
            ->findAll();
    }

    /**
     * @param int $status
     * @return int|null
     */
    public function removeExpired(int $status = self::COMPLETE_OPENED) : ?int
    {
        $this->where('expires <', $this->currentTimestamp)
            ->where('status', (int)$status)
            ->delete();

        return $this->db->affectedRows();
    }

    function isHourLimitReach($type_id = 0, $user_id = null)
    {
        $time = time() - 3600;

        $this->select('COUNT(id) as total');
        $this->where('time >', $time);
        $this->where('status', self::COMPLETE_FINISHED);

        if (is_null($user_id))
        {
            $ip_bin = inet_pton($this->input->ip_address());
            $this->where('ip_bin', $ip_bin);
        }
        else
        {
            $this->where('user_id', $user_id);
        }

        // фильтр по типу
        if ($type_id > 0)
        {
            $this->where('type_id', $type_id);
        }
        else
        {
            $type_id = 'any';
        }

        $query = $this->get($this->table)->row();

        $taskTypeModel = new TaskTypeModel();

        $typeHourLimit = $taskTypeModel->getHourLimit($type_id);

        if ($type_id && $query->total >= $typeHourLimit)
        {
            return true;
        }

        return false;
    }
}