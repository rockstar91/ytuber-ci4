<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Task extends BaseController
{

    protected $helpers = ['Auth', 'yt'];
    private $name = 'task';

    public function __construct()
    {
        helper('Auth');
        $this->user = user();
    }

    public function index()
    {
        //$type_id = ((int)$this->request->getVar('type_id')) ? (int) $this->request->getVar('type_id') : null;

        $data['pageTitle'] = lang('Task.task_list_title');

        // Типы задач
        $taskTypeModel = new \App\Models\TaskTypeModel();
        $data['types'] = $taskTypeModel->findAll();


        $taskModel = new \App\Models\TaskModel();
        $results = $taskModel->where('user_id', $this->user->id)->findAll();

        //print_r($results);
        //exit;

        $data["results"] = $results;

        //$data['pagination'] = $this->pagination->create_links();

        return view('Shitcode/task/list', $data);
    }

    //mysqldump --add-drop-table --allow-keywords --opt --where="1 ORDER BY id DESC limit 10000" -q -c -u root -h localhost -pzCzQMbG55rfHvn ytuber task | gzip -9 > task.sql.gz

    /* Index */

    public function add($param = array())
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        $data['pageTitle'] = lang('Task.task_add_title');

        // Task model
        $taskModel = new \App\Models\TaskModel();

        // Task categories
        $taskCategoryModel = new \App\Models\TaskCategoryModel();
        $data['categories'] = $taskCategoryModel->findAll();

        // Task types
        $taskTypeModel = new \App\Models\TaskTypeModel();
        $data['types'] = $taskTypeModel->findAll();

        //$this->load->library('form_validation');


        //$user = $this->User->getItem($this->user->id);

        $typeRules = $this->getRules();

        // Дополнительные поля
        $type_id = $this->request->getPost('type_id') ? (int)$this->request->getPost('type_id') : 1;
        $typeExtend = isset($typeRules[$type_id]) ? $typeRules[$type_id] : null;

        /*
        if ($typeExtend)
        {
            foreach ($typeExtend['rules'] as $item)
            {
                $validation->setRules([$item['field'], $item['name'], $item['rule']]);
            }
        }
        */

        $url_callback = !empty($typeExtend['url']['callback']) ? $typeExtend['url']['callback'] : 'callback__url';
        $data['url_placeholder'] = !empty($typeExtend['url']['placeholder']) ? $typeExtend['url']['placeholder'] : null;

        $taskValidationRules = [
            'category_id'   => ['label' => lang('Task.category'),   'rules'=> 'required|integer'],
            'type_id'       => ['label' => lang('Task.type'),       'rules' => 'required|integer'],
            'url'           => ['label' => lang('Task.url'),        'rules' =>'trim|required|callback__url_unique|' . $url_callback],
            'name'          => ['label' => lang('Task.name'),       'rules' => 'trim|min_length[4]|required'],
            'total_cost'    => ['label' => lang('Task.total_cost'), 'rules'=> 'required|numeric|greater_than_equal_to[25]|less_than_equal_to[100000]|callback__total_cost'],
            'action_cost'   => ['label' => lang('Task.action_cost'),    'rules'=> 'required|numeric|greater_than_equal_to[0.5]|less_than_equal_to[100]|callback__action_cost'],
            'hour_limit'    => ['label' => lang('Task.hour_limit'),     'rules'=> 'integer'],
        ];

        $validation->setRules($taskValidationRules);

        if( ! $this->request->getPost() || ! $validation->run() )
        {
            return view('Shitcode/task/add', $data);
        }

        // save data
        $addData = array(
            'user_id' => $this->user->id,
            'category_id' => $this->input->post('category_id'),
            'type_id' => $this->input->post('type_id'),
            'url' => $this->input->post('url'),
            'name' => $this->input->post('name'),
            'total_cost' => $this->input->post('total_cost'),
            'action_cost' => $this->input->post('action_cost'),
            'hour_limit' => $this->input->post('hour_limit'),
        );

        // Сохраняем только разрешенные доп. поля
        $addData['extend'] = serialize($this->fillExtendedFields());

        // Сортировка
        if (isset($addExtend['time']))
        {
            $addData['order'] = $addData['action_cost'] / $addExtend['time'];
        }

        // Списываем средства с баланса пользователя
        if ($this->User->decreaseBalance($this->user->id, $this->input->post('total_cost'), false))
        {
            // Добавляем задание
            if ($task_id = $this->Task->addItem($addData))
            {

                // Добавление комментов
                if (isset($addExtend['comment_text']) && $addExtend['comment_type'] == 4)
                {
                    $comments = preg_split('#[\r\n]+#', $addExtend['comment_text']);

                    foreach ($comments as $comment)
                    {
                        $this->Comment->addItem(
                            array(
                                'task_id' => $task_id,
                                'comment_text' => $comment,
                                'status' => COMMENT_FREE
                            )
                        );
                    }
                }

                $this->session->set_flashdata('success', lang('Task.success_add'));
                redirect('web/task/index');
            }
        }

        //$data['categories'] = $this->Category->getAllItems();
        //$data['types'] 		= $this->Type->getAllItems();


        if ($this->request->getVar('light'))
        {
            return view('Shitcode/task/add', $data);
        }

        return view('Shitcode/task/add', $data);

    }

    protected function getRules()
    {
        return array(
            /* Просмотры */
            TASK_VIEW => array(
                'rules' => array(
                    array(
                        'field' => 'extend[time]',
                        'name' => lang('Task.view_time'),
                        'rule' => 'trim|required|integer|greater_than_equal_to[45]|less_than_equal_to[600]|callback__extra_time' //callback__extra_time
                    )
                ),
                'fields' => array('time'),
                'url' => array(
                    'placeholder' => '',
                    'callback' => ''
                )
            ),
            /* Лайки */
            TASK_LIKE => array(
                'rules' => array(
                    array(
                        'field' => 'extend[type]',
                        'name' => lang('Task.like_type'),
                        'rule' => 'trim|required|integer|callback__extra_type'
                    )
                ),
                'fields' => array('type'),
                'url' => array(
                    'placeholder' => '',
                    'callback' => 'callback__url|callback__url_blacklist'
                )
            ),
            /* Комментарии */
            TASK_COMMENT => array(
                'rules' => array(
                    array(
                        'field' => 'extend[comment_type]',
                        'name' => lang('Task.comment_type'),
                        'rule' => 'trim|required|integer|greater_than[0]'
                    ),
                    array(
                        'field' => 'extend[comment_text]',
                        'name' => lang('Task.comment_text'),
                        'rule' => 'trim|callback__comment_text'
                    )
                ),
                'fields' => array('comment_type', 'comment_text')
            ),
            /* Подписки */
            TASK_SUBSCRIBE => array(
                'rules' => array(),
                'url' => array(
                    'placeholder' => 'https://www.youtube.com/channel/UCnASDJNJHpyO7WUbQ6AAeHA',
                    'callback' => 'callback__url_channel|callback__url_exists'
                )
            ),
            /* Модерируемое */
            101 => array(
                'rules' => array(),
                'fields' => array(),
                'url' => array(
                    'placeholder' => '',
                    'callback' => ''
                )
            ),
            102 => array(
                'rules' => array(),
                'fields' => array(),
                'url' => array(
                    'placeholder' => '',
                    'callback' => ''
                )
            ),

            /* Ответы на комментарии */
            201 => array(
                'rules' => array(
                    array(
                        'field' => 'extend[comment_id]',
                        'name' => 'ID-комментария',
                        'rule' => 'trim|required'
                    ),
                    array(
                        'field' => 'extend[comment_type]',
                        'name' => lang('Task.comment_type'),
                        'rule' => 'trim|required|integer|greater_than[0]'
                    ),
                    array(
                        'field' => 'extend[comment_text]',
                        'name' => lang('Task.comment_text'),
                        'rule' => 'trim|callback__comment_text'
                    )
                ),
                'fields' => array('comment_id', 'comment_type', 'comment_text')
            ),

            /* Комментарии */
            TASK_COMMENT_LIKE => array(
                'rules' => array(
                    array(
                        'field' => 'extend[comment_id]',
                        'name' => 'ID-комментария',
                        'rule' => 'trim|required'
                    ),
                ),
                'fields' => array('comment_id')
            ),
        );
    }


    protected function fillExtendedFields()
    {
        $result = null;

        $typeRules = $this->getRules();

        $type_id = $this->request->getPost('type_id') ?? 1;
        $typeExtend = isset($typeRules[$type_id]) ? $typeRules[$type_id] : null;


        if (isset($typeExtend['fields']) && is_array($this->request->getPost('extend')))
        {
            foreach ($this->request->getPost('extend') as $key => $val)
            {
                if (in_array($key, $typeExtend['fields']))
                {
                    $result[$key] = $val;
                }
            }
        }

        return $result;
    }

    /* Remove */

    public function remove()
    {
        $id = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
        if ($task = $this->Task->getItem($id))
        {
            if ($this->user->admin || $this->user->id == $task->user_id)
            {

                if (!$this->user->admin && strtotime($task->added) > (time() - 3600))
                {
                    $this->session->set_flashdata('error', lang('Task.error_remove_time'));
                    redirect('task/index');
                }

                if ($this->User->increaseBalance($task->user_id, $task->total_cost))
                {
                    if ($this->Task->removeItem($task->user_id, $id))
                    {

                        $this->Comment->removeByTaskId($id); // удаляем комменты

                        $this->session->set_flashdata('success', sprintf(lang('Task.success_remove'), $id));
                        redirect($this->user->admin ? $_SERVER['HTTP_REFERER'] : 'task/index');
                    }
                }
            }
        }
        $this->session->set_flashdata('error', sprintf(lang('Task.error_remove'), $id));
        redirect('task/index');
    }


    function _url($url)
    {
        if (preg_match('#^http(s){0,1}://(www|m)\.youtube\.com/watch\?v=([a-z0-9-_]{11})(\&t=[a-z0-9-_]{2,8}){0,1}$#i', $url))
        {
            $result = true;
        } else if (preg_match('#^http(s){0,1}://youtu\.be/([a-z0-9-_]{11})(\?t=[a-z0-9-_]{2,8}){0,1}$#i', $url))
        {
            $result = true;
        } else
        {
            $this->form_validation->set_message('_url', lang('Task.valid_url'));
            return false;
        }

        return $result;
    }

    function _url_channel($url)
    {
        $url = str_replace('?view_as=subscriber', '', $url);

        if (preg_match('#^http(s){0,1}://www\.youtube\.com/channel/([a-z0-9-_]{24})$#i', $url))
        {
            return $url;
        } else
        {
            $this->form_validation->set_message('_url_channel', lang('Task.valid_url_channel'));
            return false;
        }

        return $result;
    }

    function _url_unique($url)
    {
        $id = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
        $type_id = $this->input->post('type_id');

        //if($type_id == TASK_SUBSCRIBE OR $type_id == TASK_LIKE) {
        if ($this->Task->isItemExist($url, $id, $type_id, $this->user->id))
        {
            $this->form_validation->set_message('_url_unique', lang('Task.valid_url_unique'));
            return false;
        }
        //}

        return true;
    }

    function _valid_url_format($str)
    {
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str))
        {
            $this->form_validation->set_message('_valid_url_format', lang('Task.valid_url_format'));
            return FALSE;
        }
        return TRUE;
    }

    function _url_exists($url)
    {
        $url_data = parse_url($url); // scheme, host, port, path, query
        if (!fsockopen($url_data['host'], isset($url_data['port']) ? $url_data['port'] : 80))
        {
            $this->form_validation->set_message('_url_exists', lang('Task.valid_url_exists'));
            return FALSE;
        }
        return TRUE;
    }

    function _total_cost($total_cost)
    {
        $user = $this->User->getItem($this->user->id);

        if ($user->admin)
        {
            return true;
        }

        if (!$user OR $user->balance < $total_cost)
        {
            $this->form_validation->set_message('_total_cost', lang('Task.valid_total_cost'));
            return false;
        }
        return true;
    }

    function _total_cost_edit($total_cost)
    {
        $id = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
        $task = $this->Task->getItemByUser($this->user->id, $id);
        $user = $this->User->getItem($this->user->id);

        //if($user->admin) {
        //    return true;
        //}

        if (!$user OR !$task OR ($user->balance + $task->total_cost) < $total_cost)
        {
            $this->form_validation->set_message('_total_cost_edit', lang('Task.valid_total_cost'));
            return false;
        }

        $this->_increase = $task->total_cost - $total_cost;
        return true;
    }

    function _action_cost($action_cost)
    {
        // общая цена не может быть меньше цены за дейсвие
        $total_cost = $this->input->post('total_cost');

        if ($total_cost < $action_cost)
        {
            $this->form_validation->set_message('_action_cost', lang('Task.valid_action_cost'));
            return false;
        }
        return true;
    }


    function _extra_time($time)
    {
        $action_cost = $this->input->post('action_cost');

        $tpl = 'Поле Цена должно содержать значение больше или равно %s.';

        if ($time >= 600 && $action_cost < 1.2)
        {
            $min = 1.2;
        } else if ($time >= 300 && $action_cost < 1)
        {
            $min = 1;
        } else if ($time >= 180 && $action_cost < 0.8)
        {
            $min = 0.8;
        } else if ($time >= 90 && $action_cost < 0.65)
        {
            $min = 0.65;
        } else if ($time >= 60 && $action_cost < 0.6)
        {
            $min = 0.6;
        }

        if (isset($min))
        {
            $this->form_validation->set_message('_extra_time', sprintf($tpl, $min));
            return false;
        }

        return true;
    }


    function _comment_text($text)
    {
        $extend = $this->input->post('extend');
        $total_cost = $this->input->post('total_cost');
        $action_cost = $this->input->post('action_cost');

        if (isset($extend['comment_type']) && $extend['comment_type'] != 4)
        {
            return true;
        }

        $minComments = @floor($total_cost / $action_cost);
        $minSymbols = 5;

        $error = 0;


        $ex = preg_split('#[\r\n]+#', $text);
        //$ex = explode(PHP_EOL, $text);

        if (count($ex) < $minComments)
        {
            $error++;
        }

        foreach ($ex as $str)
        {
            // вырезание ссылок
            $str = preg_replace('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', '', $str);
            // trim
            $str = trim(strip_tags($str));

            if (mb_strlen($str) < $minSymbols)
            {
                $error++;
            }
        }

        if ($error > 0)
        {
            $this->form_validation->set_message('_comment_text', sprintf(lang('Task.valid_comment_text'), $minComments, $minSymbols));
            return false;
        }

        return implode("\r\n", $ex);
    }

    function _extra_type($type)
    {
        $allow = array(1, 2);
        if (!in_array($type, $allow))
        {
            $this->form_validation->set_message('_extra_type', lang('Task.valid_extra_type'));
            return false;
        }

        return true;
    }
}