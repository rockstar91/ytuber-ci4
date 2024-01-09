<?php
namespace App\Entities;

use CodeIgniter\Entity;


class Complete extends Entity
{
    protected $attributes = [
        'id'            => null,
        'task_id'       => null,
        'user_id'       => null
    ];

    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'completed_at'];

    protected $casts = [
        'id'    => 'int',
    ];

}