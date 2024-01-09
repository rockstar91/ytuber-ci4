<?php
namespace App\Entities;

use CodeIgniter\Entity;


class AccountType extends Entity
{
    protected $attributes = [
        'id'        => null,
        'name'      => null,
        'pattern'   => null,
        'example'   => null
    ];

    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'completed_at'];

    //
    protected $casts = [
        'id'    => 'int',
    ];

}