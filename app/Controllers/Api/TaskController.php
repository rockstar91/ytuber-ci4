<?php


namespace App\Controllers\Api;


use App\Models\TaskModel;
use App\Models\UserModel;

class TaskController extends BaseApiController
{
    protected $modelName = 'App\Models\TaskModel';

    protected $methodsMapping = [
        'getTaskList' => 'getList',
        'getById'     => 'show'
    ];

    protected $perPage = 15;
    protected $pageSegment = 4;

    public function __construct()
    {
        $config = new \Config\Pager();
        $this->perPage = $config->perPage;
    }

    public function getOwner($task_id)
    {
        $task = $this->model->find($task_id);

        if ( ! $task OR ! $user = $task->getTaskOwner()) {
            return $this->failNotFound();
        }

        return $this->respond($user);
    }

    public function show($id = null)
    {
        // если нет id
        if( $id <= 0 ) {
            return $this->failNotFound();
        }

        $task = $this->model->find($id);

        if (!$task) {
            $this->failNotFound();
        }

        return  $this->respond($task);
    }

    public function getTest()
    {
        $taskModel = new TaskModel();

        $offset = rand(0, 100);
        $task = $taskModel->getItemsAvailableGeoWithOpened($this->user->id, 1, 't.order', 1, $offset, true);

        print_r($task);
    }

    public function getRandomVIdeoForYoutubeApiPlayer($type_id=null)
    {
        //$this->load->model('Youtube_Model', 'Youtube');
        //$this->load->helper('yt');
        //$this->load->helper('google');
        //$this->load->language('yt');


        //if(!google_youtube_check_channel($this->user, $yt)) {
        //    $this->output->json(array('error' => 'Ваш канал недоступен.'));
        //}

        // Лимит выполнений в час по ip
        if($this->Complete->isHourLimitReach($type_id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }
        // Лимит выполнений в час по ip
        if($this->Complete->isHourLimitReach($type_id, $this->user->id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        $rand = mt_rand(0, 20);

        // Получаем видео
        //$results = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, 't.order', 0, 90, true, true);
        $results = $this->Task->getItemsAvailableGeoWithOpened($this->user->id, $type_id, 't.order', 1, $rand, true);

        if($results) {
            //shuffle($results);
            $task = $this->Task->_extendItem(array_first($results));

            if($vid = yt_vid($task->url)) {
                $task->vid = $vid;
            }

            if($channel = yt_channel($task->url)) {
                $task->channel = $channel;
            }

            /* Подписки */
            if($task->type_id == TASK_SUBSCRIBE) {
                // Возраст YouTube канала пользователя в днях
                if($this->user->channel_published > 0) {
                    $channel_age = time() - strtotime($this->user->channel_published);
                    $channel_age = intval($channel_age / 86400);
                }
                else {
                    $channel_age = 0;
                }

                $error = $this->lang->line('error_subscribe_limit');

                //коэфицент
                $b = 4.5;
                $log2 = log($b) * log($channel_age) * $b;
                //лимит подписчиков для данного возраста канала
                $limit = round((log($channel_age)*$log2*log($b)));

                try {
                    // Общее количество подписок пользователя
                    $listSubscriptions  = $yt->subscriptions->listSubscriptions('snippet', array('mine' => true));
                    $totalSubscriptions = $listSubscriptions->getPageInfo()->getTotalResults();

                    if($totalSubscriptions >= $limit)
                    {
                        $this->output->json(array('error' => sprintf($error, $limit)));
                    }
                }
                catch(Exception $e) {
                    $this->output->json(array('error' => sprintf($error, 0)));
                }
            }

            register_shutdown_function(array($this, 'getWorkShutdownCallback'), $task);

            // Удаляем стартовую метку для других просмотров для user_id
            if(isset($task->extend['time'])) {
                $this->Complete->remove($this->user->id, null, $task->type_id, COMPLETE_OPENED);
            }

            // Запись о начале просмотра в бд
            $added = $this->Complete->add($this->user->id, $task, COST_API, null, $task->youtube);

            if(!$added) {
                $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
            }

            $this->output->json($task);
        }
        else {
            $this->output->json(array('error' => 'not found available task'));
        }
    }

    public function getList($page = null, $me = false, $taskTypeId = null)
    {

        // Режим отображения (выборка только разрешенных полей)
        $this->model->displayModeOn();

        $displayFields = $this->request->getGet('fields');

        if( ! empty($displayFields) ) {
            $this->model->fillDisplayFields($displayFields);
        }

        // бюджет больше цены за действие
        $this->model->where('total_cost >', 'action_cost');

        // Только свои задачи
        if($me) {
            $this->model->where('user_id', $this->user->id);
        }

        // Сортировка
        if($me) {
            $this->model->orderBy('created_at', 'DESC');
        }
        else {
            $this->model->orderBy('order', 'DESC');
        }

        // Задачи определенного типа
        if($taskTypeId) {
            $this->model->where('type_id', (int) $taskTypeId);
        }

        // номер страницы
        $page = $page <= 0 ? 1 : (int) $page;

        // сегмент
        $segment = 4;

        $data = [
            'tasks' => $this->model->paginate($this->perPage, 'default', $page, $this->pageSegment),
            'pager' => $this->model->pager->getDetails()
        ];

        return ! $data['tasks'] ? $this->failNotFound() : $this->respond($data);
    }

    public function edit($id = null)
    {
        // если нет id
        if( $id <= 0 ) {
            return $this->failNotFound();
        }

        $task = $this->model
            ->with('tasks_to_referral_sources')
            ->with('tasks_comments')
            ->find($id);

        if ( ! $task ) {
            return $this->failNotFound();
        }

        if($task->user_id != $this->user->id && ! $this->user->admin) {
            return $this->failForbidden();
        }

        return $this->respond($task);
    }

    public function create()
    {
        $data = $this->request->getJSON();

        if( ! $data) {
            return $this->fail('No have request data');
        }

        // добавление user_id в набор данных
        $data->user_id = $this->user->id;

        $id = $this->model->insertWith($data);

        if ($this->model->errors()) {
            return $this->fail($this->model->errors());
        }

        if ($id === false) {
            return $this->failServerError();
        }

        return $this->respondCreated(['id' => $id]);
    }

    public function update($id = NULL) {
        // если нет id
        if( $id <= 0 ) {
            return $this->failNotFound();
        }

        $data = $this->request->getRawInput();

        $updated = $this->model->update($id, $data);

        if ($this->model->errors()) {
            return $this->fail($this->model->errors());
        }

        if ($updated === false) {
            return $this->failServerError();
        }

        return $this->respondUpdated($this->model->find($id));
    }

    public function delete($id = null)
    {
        $task = $this->model->find($id);

        // Задача существует
        if ( ! $task OR $id <= 0 ) {
            return $this->failNotFound();
        }

        // Задача принадлежит пользователю или у текущего пользователя есть админ-права
        if($task->user_id != $this->user->id && ! $this->user->admin) {
            return $this->failForbidden();
        }

        // Возврат баллов пользователю
        $userModel = new UserModel();
        $userModel->increaseBalance($task->user_id, $task->total_cost);

        // Комменты удалятся по цепочке

        // Удаление задачи
        if($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        else {
            return $this->failServerError();
        }

    }
}