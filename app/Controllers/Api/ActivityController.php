<?php


namespace App\Controllers\Api;


class ActivityController extends BaseApiController
{
    protected $modelName = '\App\Models\ActivityModel';

    protected $latestActivityListLimit = 10;


    public function getLatestActivityList()
    {
        $userId = 654444; // $this->user->id
        $latestActivityList = $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($this->latestActivityListLimit)
            ->find();

        return $this->respond($latestActivityList);
    }
}