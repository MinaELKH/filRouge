<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * TaskService constructor.
     *
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks for current user
     *
     * @return mixed
     */
    public function getAllUserTasks()
    {
        return $this->taskRepository->getAllTasksByUser(Auth::id());
    }

    /**
     * Get task by ID
     *
     * @param int $taskId
     * @return mixed
     */
    public function getTask($taskId)
    {
        $task = $this->taskRepository->getTaskById($taskId);

        // Vérifier si l'utilisateur est autorisé à accéder à cette tâche
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        return $task;
    }

    /**
     * Create new task
     *
     * @param array $data
     * @return mixed
     */
    public function createTask(array $data)
    {
        $taskData = [
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'budget' => $data['budget'] ?? null,
            'reference_number' => $data['reference_number'] ?? null,
            'status' => 'pending'
        ];

        return $this->taskRepository->createTask($taskData);
    }

    /**
     * Update existing task
     *
     * @param int $taskId
     * @param array $data
     * @return mixed
     */
    public function updateTask($taskId, array $data)
    {
        $task = $this->getTask($taskId);

        $taskData = [
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'category' => $data['category'] ?? $task->category,
            'budget' => $data['budget'] ?? $task->budget,
            'reference_number' => $data['reference_number'] ?? $task->reference_number
        ];

        // Si le statut est fourni dans les données, le mettre à jour
        if (isset($data['status'])) {
            $taskData['status'] = $data['status'];
        }

        return $this->taskRepository->updateTask($taskId, $taskData);
    }

    /**
     * Delete task
     *
     * @param int $taskId
     * @return bool
     */
    public function deleteTask($taskId)
    {
        $this->getTask($taskId); // Vérifie les autorisations
        return $this->taskRepository->deleteTask($taskId);
    }

    /**
     * Complete task
     *
     * @param int $taskId
     * @return mixed
     */
    public function completeTask($taskId)
    {
        $this->getTask($taskId); // Vérifie les autorisations
        return $this->taskRepository->updateTaskStatus($taskId, 'completed');
    }

    /**
     * Mark task as pending
     *
     * @param int $taskId
     * @return mixed
     */
    public function pendingTask($taskId)
    {
        $this->getTask($taskId); // Vérifie les autorisations
        return $this->taskRepository->updateTaskStatus($taskId, 'pending');
    }
}
