<?php


namespace App\Controllers\Api;


class ArticleController extends BaseApiController
{
    protected $modelName = 'App\Models\ArticleModel';

    public function show($id = null)
    {
        $article = $this->model->find($id);

        if (!$article) {
            $this->failNotFound();
        }

        return  $this->respond($article);
    }
}