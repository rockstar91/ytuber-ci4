<?php


namespace App\Models;


class TaskToReferralSourceModel extends BaseModel
{
    protected $table      = 'tasks_to_referral_sources';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';
    protected $useTimestamps = true;

    protected $allowedFields = ['referral_source_id', 'task_id'];


    public function deleteByTaskId($taskId)
    {
        $this->where('task_id', (int) $taskId);
        return $this->delete();
    }
}