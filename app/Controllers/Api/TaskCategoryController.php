<?php
namespace App\Controllers\Api;

use App\Models\TaskCategoryModel;

class TaskCategoryController extends BaseApiController
{
    protected $modelName = 'App\Models\TaskCategoryModel';

    public function getList()
    {
        $result = $this->model->findAll();
        return $this->response->setJSON($result);
    }
}