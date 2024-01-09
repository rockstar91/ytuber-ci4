<?php


namespace App\Models;

use CodeIgniter\Model;

class BonusModel extends Model
{
    protected $userId;
    protected $offset;

    // типы задач и значения счетчика по-умолчанию
    protected $typeCounters = [
        TaskModel::TASK_VIEW => 0,
        TaskModel::TASK_LIKE => 0,
        TaskModel::TASK_SUBSCRIBE => 0,
        TaskModel::TASK_COMMENT => 0
    ];

    protected $typeTargetCounters = [
        TaskModel::TASK_VIEW => 90,
        TaskModel::TASK_LIKE => 15,
        TaskModel::TASK_SUBSCRIBE => 3,
        TaskModel::TASK_COMMENT => 5
    ];

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        // сдвиг по времени
        $this->setOffset(time() - strtotime(date('Y-m-d 00:00:00')));

        $this->setUserId(user()->id);

        $this->fillUserStats();
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function setOffset($value)
    {
        $this->offset = $value;
    }

    public function fillUserStats()
    {
        // подсчет завершенных выполнений по типу задачи
        $completeModel = new CompleteModel();
        $finished = $completeModel->countFinishedByUser($this->userId, $this->offset);

        foreach ($finished as $item) {
            if(isset($this->typeCounters[$item->type_id])) {
                $this->typeCounters[$item->type_id] = $item->total;
            }
        }
    }

    public function isTargetsReach()
    {
        $reach = 0;
        foreach($this->typeCounters as $id=>$counter) {
            $reach += ($counter >= $this->typeTargetCounters[$id]);
        }

        return ($reach >= count($this->typeTargetCounters));
    }

    public function getData()
    {
        // подсчет процента для прогрессбара
        $result = [];

        foreach($this->typeCounters as $id=>$count) {
            $result[$id] = [
                'total'     => $count,
                'target'    => $this->typeTargetCounters[$id],
                'percent'   => $count*100 / $this->typeTargetCounters[$id],
            ];
        }

        return $result;
    }
}