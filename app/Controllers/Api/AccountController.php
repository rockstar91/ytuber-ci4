<?php


namespace App\Controllers\Api;


class AccountController extends BaseApiController
{
    protected $modelName = 'App\Models\AccountMainModel';

    public function getList() {
        $result = $this->model->getAccountsByUserId($this->user->id);
        return $this->response->setJSON($result);
    }

    public function getGoogleYoutubeList()
    {
        $result = $this->model
            ->with('accounts_google_youtube')
            ->getAccountsByUserId($this->user->id);

        return $this->response->setJSON($result);
    }

}