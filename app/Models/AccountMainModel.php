<?php namespace App\Models;

use CodeIgniter\Model;


class AccountMainModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    const USER_ACCOUNT_WAITING = 0;
    const USER_ACCOUNT_FAILED  = 1;
    const USER_ACCOUNT_ACTIVE  = 2;

    protected $table      = 'accounts';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\AccountMain';
    protected $protectFields = false;

    /**
     * @param $user_id
     * @param null $account_type_id
     * @return array|null
     */
    function getAccountsByUserId($user_id, $account_type_id=null)
    {
        $this->where('user_id', (int)$user_id);

        if($account_type_id) {
            $this->where('account_type_id', (int)$account_type_id);
        }

        return $this->findAll();
    }

    /**
     * @param $user_id
     * @param $account_type_id
     * @return bool
     */
    function isHaveAccount($user_id, $account_type_id) : bool
    {
        $this->where('user_id', (int)$user_id)
            ->where('account_type_id', (int)$account_type_id)
            ->where('status', USER_ACCOUNT_ACTIVE);

        return ($this->countAllResults()>0);
    }
}