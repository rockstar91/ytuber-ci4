<?php


namespace App\Models;


class ActivityModel extends BaseModel
{
    protected $table      = 'notifications';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';
}