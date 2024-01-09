<?php

namespace App\Entities;

use CodeIgniter\Entity;


/**
 * Class Task
 * @package App\Entities
 */
class Task extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'completed_at'];

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'category_id' => 'int',
        'type_id' => 'int',
        'disabled' => 'boolean',
        'geo' => 'boolean',
        'extend' => 'array'
    ];

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->attributes['url'];
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        if (!$this->isDisabled())
        {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        if ($this->attributes['disabled'])
        {
            return true;
        }
    }

    public function getTaskCategory()
    {
        $taskCategoryModel = new \App\Models\TaskCategoryModel();
        return $taskCategoryModel->find((int)$this->attributes['category_id']);
    }

    /**
     * @return array|null|object
     */
    public function getUser()
    {
        return $this->getTaskOwner();
    }

    /**
     * @return array|null|object
     */
    public function getTaskOwner()
    {
        $userModel = new \App\Models\UserModel();
        return $userModel->find((int)$this->attributes['user_id']);
    }

    /**
     *
     */
    public function countCompetionMarks()
    {

    }
}