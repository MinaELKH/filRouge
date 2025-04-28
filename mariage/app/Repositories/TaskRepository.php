<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var Task
     */
    protected $model;

    /**
     * TaskRepository constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * Get all tasks for a specific user
     *
     * @param int $userId
     * @return mixed
     */
    public function getAllTasksByUser($userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get task by ID
     *
     * @param int $taskId
     * @return mixed
     */
    public function getTaskById($taskId)
    {
        return $this->model->findOrFail($taskId);
    }

    /**
     * Create new task
     *
     * @param array $taskData
     * @return mixed
     */
    public function createTask(array $taskData)
    {
        return $this->model->create($taskData);
    }

    /**
     * Update existing task
     *
     * @param int $taskId
     * @param array $taskData
     * @return mixed
     */
    public function updateTask($taskId, array $taskData)
    {
        $task = $this->getTaskById($taskId);
        $task->update($taskData);
        return $task;
    }

    /**
     * Delete task
     *
     * @param int $taskId
     * @return bool
     */
    public function deleteTask($taskId)
    {
        return $this->getTaskById($taskId)->delete();
    }

    /**
     * Update task status
     *
     * @param int $taskId
     * @param string $status
     * @return mixed
     */
    public function updateTaskStatus($taskId, $status)
    {
        $task = $this->getTaskById($taskId);
        $task->status = $status;
        $task->save();
        return $task;
    }
}
