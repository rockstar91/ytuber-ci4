<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.05.2020
 * Time: 01:44
 */

namespace App\Traits\Entities;


trait Account
{
    protected $baseAccount = null;

    // Подтягивает данные базового аккаунта
    public function getBaseAccount()
    {
        if(!$this->baseAccount)
        {
            $accountModel = new \App\Models\AccountMainModel();
            $this->baseAccount = $accountModel->find($this->attributes['account_id']);
        }

        return $this->baseAccount;
    }
}