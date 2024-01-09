<?php namespace App\Models;

use CodeIgniter\Model;

class AccountVkModel extends AccountBaseModel
{
    protected $table = 'accounts_vk';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\AccountVk';
    protected $protectFields = false;
}