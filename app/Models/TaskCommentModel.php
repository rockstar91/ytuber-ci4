<?php


namespace App\Models;


class TaskCommentModel extends BaseModel
{
    const COMMENT_FREE = 1;
    const COMMENT_WAITING = 2;
    const COMMENT_COMPLETE = 3;

    protected $table      = 'tasks_comments';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';
    protected $useTimestamps = true;

    protected $allowedFields = ['task_id', 'comment_text', 'status'];

    protected $validationRules = [
        'comment_text' => 'trim|min_length[6]|required',
        'status' => 'integer|required'
    ];

    public function deleteByTaskId($taskId)
    {
        $this->where('task_id', (int) $taskId);
        return $this->delete();
    }
}