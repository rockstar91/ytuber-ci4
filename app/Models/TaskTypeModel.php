<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.05.2020
 * Time: 04:55
 */

namespace App\Models;

use CodeIgniter\Model;

class TaskTypeModel extends BaseModel
{
    // все, разрешенные для выборки поля в режиме dispayMode
    protected $allowedDisplayFields = ['id', 'name'];

    protected $table      = 'tasks_types';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';

    public function getHourLimit($id)
    {
        $type = $this->find($id);
        return $type ? $type->hour_limit : false;
    }

    function getCompleteDays($id)
    {
        $type = $this->find($id);
        return $type ? $type->complete_days : false;
    }
}