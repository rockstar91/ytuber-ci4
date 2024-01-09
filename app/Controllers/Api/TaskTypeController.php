<?php


namespace App\Controllers\Api;
use App\Models\TaskTypeModel;


class TaskTypeController extends BaseApiController
{
    protected $modelName = 'App\Models\TaskTypeModel';

    public function getList()
    {
        $result = $this->model->findAll();
        return $this->response->setJSON($result);
    }
}