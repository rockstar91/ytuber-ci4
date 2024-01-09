<?php namespace App\Models;

use CodeIgniter\Model;


class AccountTypeModel extends Model
{
    protected $table      = 'accounts_types';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\AccountType';
    protected $protectFields = false;
}