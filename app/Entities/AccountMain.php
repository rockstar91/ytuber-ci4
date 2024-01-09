<?php

namespace App\Entities;

use App\Models\AccountModelLocator;
use CodeIgniter\Entity;
use App\Models\AccountTypeModel;
use App\Models\UserModel;
//use App\Libraries\Utils\ServiceLocator;
//use App\Models\AccountModelLocator;


class AccountMain extends Entity
{

    protected $accountType = null;
    protected $accountData = null;

    protected $attributes = [
        'id'                => null,
        'user_id'           => null,
        'account_type_id'   => null,
    ];

    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    //
    protected $casts = [
        'id'    => 'int',
    ];

    protected $childAccountModels = [
        1 => 'App\Models\AccountGoogleYoutube'
    ];

    public function getUser()
    {
        $users = new UserModel();
        return $users->find((int)$this->attributes['user_id']);
    }

    // Подтягивает данные о типе аккаунта из accounts_type
    public function getAccountType()
    {
        if(is_null($this->accountType))
        {
            $accounts = new AccountTypeModel();
            $this->accountType = $accounts->find($this->attributes['account_type_id']);
        }

        return !is_null($this->accountType) ? $this->accountType : null;
    }

    public function getChildAccount()
    {
        $childAccountModel = $this->getChildAccountModel($this->attributes['account_type_id']);

        return $childAccountModel->where('account_id', $this->attributes['id'])->first();
    }

    protected function getChildAccountModel($account_type_id)
    {
        if(isset($this->childAccountModels[$account_type_id]))
        {
            return new $this->childAccountModels[$account_type_id];
        }
        else
        {
            throw new Exception("Doesn't exist model for 'account_type_id' = " . $account_type_id);
        }
    }
}