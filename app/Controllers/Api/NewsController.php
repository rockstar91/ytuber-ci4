<?php


namespace App\Controllers\Api;


class NewsController extends BaseApiController
{
    protected $modelName = 'App\Models\NewsModel';

    public function show($id = null, $limit = 5)
    {

        $news = $this->model->limit($limit)->orderBy('date DESC')->find($id);

        if (!$news) {
            $this->failNotFound();
        }

        return  $this->respond($news);
    }
}