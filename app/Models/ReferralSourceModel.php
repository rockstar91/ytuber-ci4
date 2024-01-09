<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.05.2020
 * Time: 05:06
 */

namespace App\Models;

use CodeIgniter\Model;

class ReferralSourceModel extends  BaseModel
{
    // все, разрешенные для выборки поля в режиме dispayMode
    protected $allowedDisplayFields = ['id', 'name'];

    protected $table      = 'referral_sources';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';

}