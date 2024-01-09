<?php namespace App\Models;

use App\Traits\Relations\ModelTrait;
//use CodeIgniter\Model;

class TaskModel extends BaseModel
{
    //use \Tatter\Relations\Traits\ModelTrait;
    use ModelTrait;

    const TASK_VIEW = 1;
    const TASK_LIKE = 2;
    const TASK_COMMENT = 3;
    const TASK_SUBSCRIBE = 4;
    const TASK_COMMENT_LIKE = 7;
    const TASK_VK = 101;
    const TASK_TWITTER = 102;
    const TASK_REPLY = 201;

    // все, разрешенные для выборки поля в режиме dispayMode
    protected $allowedDisplayFields = [
        'id', 'user_id', 'category_id', 'type_id',
        'url', 'name', 'total_cost', 'action_cost',
        'action_done', 'action_fail', 'action_refund', 'extend', 'targetTime', 'channelAgeLimit',
        'videosCountLimit', 'order'
    ];

    protected $table      = 'tasks';
    protected $primaryKey = 'id';

    protected $returnType    = 'App\Entities\Task';

    protected $useSoftDeletes = true;

    protected $with = ['tasks_categories', 'tasks_types'];

    protected $allowedFields = [
        'user_id',
        'category_id',
        'type_id',
        'report',
        'url',
        'name',
        'description',
        'total_cost',
        'action_cost',
        'action_done',
        'action_fail',
        'action_refund',
        'hour_limit',
        'hour_done',
        'youtube',
        'youtube_initial',
        'youtube_extend',
        'extend',
        'order',
        'created_at',
        'updated_at',
        'completion',
        //'geo',
        'disabled',
        'removed',

        'targetTime',
        'channelAgeLimit',
        'videosCountLimit'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'user_id'       => 'required|integer|greater_than_equal_where[users.id,balance,{total_cost}]',
        'category_id'   => 'required|integer',
        'type_id'       => 'required|integer',
        'url'           => 'trim|required|is_unique_where[tasks.url,type_id,{type_id}]', // $url_callback
        'name'          => 'trim|min_length[6]|required',
        'total_cost'    => 'required|numeric|greater_than_equal_to[100]|less_than_equal_to[500000]|greater_than_equal_to[{action_cost}]',
        'action_cost'   => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[500]',
        'hour_limit'    => 'required|integer',

        'targetTime'        => 'required|integer|greater_than_equal_to[30]|less_than_equal_to[600]',
        'channelAgeLimit'   => 'required|integer',
        'videosCountLimit'  => 'required|integer'
    ];

    protected $validationMessages = [
        'user_id' => [
            'greater_than_equal_where' => 'Бюджет задачи превышает количество доступных баллов'
        ],
        'url' => [
            'is_unique_where' => 'Эта ссылка уже есть в базе данных'
        ]
    ];

    protected $skipValidation = false;

    // возвращает задачи доступные для выполнения пользователю
    public function getItemsAvailableGeoWithOpened($user_id, $type_id, $order_by, $limit=1, $offset=0, $notDone = false)
    {
        $taskTypeModel = new TaskTypeModel();
        $completeDays = $taskTypeModel->getCompleteDays($type_id);
        $completeTime = $completeDays ? time() - ($completeDays * 86400) : time() - (90 * 86400);


        $where = $notDone ? 'd.time is null AND ' : '';

        $now = time();

        $sql = "
            SELECT t.*, d.user_id, d.task_id, d.time as done, d.status as c_status, t.user_id as author_id, (t.total_cost / t.action_cost) as action_remain,
            ( SELECT COUNT(id) FROM completions WHERE task_id = t.id AND expires > ". $now ." AND status = " . CompleteModel::COMPLETE_OPENED . " ) as opened 

            FROM " . $this->table . " t
            LEFT JOIN completions d ON(d.user_id = {$user_id} AND d.task_id = t.id AND d.time > {$completeTime})
            WHERE
                #t.removed  = 0 AND
                t.disabled = 0 AND 
                t.type_id  = {$type_id} AND
                {$where}
                #t.completion < NOW() - INTERVAL 1 MINUTE AND
                t.total_cost >= t.action_cost AND
                (t.total_cost / t.action_cost) > ( SELECT COUNT(id) FROM completions WHERE task_id = t.id AND expires > ". $now ." AND status = " . CompleteModel::COMPLETE_OPENED . " ) AND
                (t.hour_limit > t.hour_done OR t.hour_limit = 0) 
        
            #GROUP BY t.id
            ORDER BY {$order_by} DESC
            LIMIT {$offset}, {$limit}
        ";

        $query = $this->db->query($sql);

        return $query->getResult();
    }

    public function insertWith($data = null)
    {
        // TODO: сделать валидацию источников трафика и комментов

        $userModel = new UserModel();


        if(
            // валидация задачи
            ! $this->validate($data) ||
            // списание средств у пользователя
            ! $userModel->decreaseBalance($data->user_id, $data->total_cost) ||
            // добавление задачи
            ! ($taskId = $this->insert($data))
        ) {
            return false;
        }

        // Добавление источников трафика
        if(is_array($data->referralSources))
            $this->insertReferralSources($taskId, $data->referralSources);

        // Добавление комментариев
        $this->insertComments($taskId, $data->customCommentList);


        return $taskId;
    }

    public function insertComments(int $taskId, array $comments)
    {
        $taskCommentModel = new TaskCommentModel();

        // удаление существующих записей
        $taskCommentModel->deleteByTaskId($taskId);

        // должен быть массив с комментариями
        if( ! is_array($comments) OR count($comments) <= 0)
        {
            return false;
        }

        // добавление комментов
        foreach ($comments as $comment)
        {
            //print_r($comment);

            $data = [
                'task_id'       => $taskId,
                'comment_text'  => $comment->text,
                'status'        => $taskCommentModel::COMMENT_FREE
            ];

            $taskCommentModel->insert($data);
        }

        return;
    }

    public function insertReferralSources(int $taskId, array $referralSources)
    {
        // Список источников трафика
        $taskToReferralSourceModel = new TaskToReferralSourceModel();

        // удаление существующих записей
        $taskToReferralSourceModel->deleteByTaskId($taskId);

        // должен быть массив с источниками
        if(! is_array($referralSources) OR count($referralSources) <= 0)
        {
            return false;
        }

        // добавление новых записей
        foreach ($referralSources as $referralSource)
        {
            $data = [
                'referral_source_id' => $referralSource->id,
                'task_id' => $taskId
            ];

            $taskToReferralSourceModel->insert($data);
        }
    }

    public function delete($id = null, bool $purge = false)
    {
        return parent::delete($id, $purge); // TODO: Change the autogenerated stub
    }

    public function insert($data = null, bool $returnID = true)
    {
        return parent::insert($data, $returnID); // TODO: Change the autogenerated stub
    }
}
