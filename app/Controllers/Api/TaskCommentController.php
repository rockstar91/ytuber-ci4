<?php


namespace App\Controllers\Api;


class TaskCommentController extends BaseApiController
{
    protected $modelName = 'App\Models\TaskCommentModel';

    protected function getByTaskId(int $taskId, int $status)
    {
        $data = $this->model
            ->where('task_id', $taskId)
            ->where('status', $status)
            ->first();

        return $data;
    }

    public function getFree(int $taskId)
    {
        // TODO: считать, сколько открытых комментов у пользователя, во избежании скликивания комментов

        $comment = $this->getByTaskId($taskId, $this->model::COMMENT_FREE);

        if($comment)
        {
            // помечаем коммент как открытый и ожидающий проверки
            $this->model->update($comment->id, [
                'status' => $this->model::COMMENT_WAITING
            ]);

            return $this->respond($comment);
        }
        else
        {
            return $this->failNotFound();
        }
    }

    public function setComplete(int $commentId)
    {
        // TODO: проверять права доступа пользователя

        $this->model->update($commentId, [
            'status' => $this->model::COMMENT_COMPLETE
        ]);

        return $this->respondUpdated(['id' => $commentId]);
    }
}