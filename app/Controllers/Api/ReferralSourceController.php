<?php

namespace App\Controllers\Api;

use App\Models\TaskCategoryModel;

class ReferralSourceController extends BaseApiController
{
    protected $modelName = 'App\Models\ReferralSourceModel';

    public function getList()
    {
        $this->model->displayModeOn();
        $result = $this->model->findAll();
        return $this->response->setJSON($result);
    }
}