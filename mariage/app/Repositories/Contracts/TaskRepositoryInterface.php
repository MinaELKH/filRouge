<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks for a specific user
     *
     * @param int $userId
     * @return mixed
     */
    public function getAllTasksByUser($userId);

    /**
     * Get task by ID
     *
     * @param int $taskId
     * @return mixed
     */
    public function getTaskById($taskId);

    /**
     * Create new task
     *
     * @param array $taskData
     * @return mixed
     */
    public function createTask(array $taskData);

    /**
     * Update existing task
     *
     * @param int $taskId
     * @param array $taskData
     * @return mixed
     */
    public function updateTask($taskId, array $taskData);

    /**
     * Delete task
     *
     * @param int $taskId
     * @return bool
     */
    public function deleteTask($taskId);

    /**
     * Update task status
     *
     * @param int $taskId
     * @param string $status
     * @return mixed
     */
    public function updateTaskStatus($taskId, $status);
}
