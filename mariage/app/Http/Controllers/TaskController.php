<?php

namespace App\Http\Controllers;

//use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected $taskService;

    /**
     * TaskController constructor.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
        $this->middleware('auth');
    }

    /**
     * Affiche la liste des tâches de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = $this->taskService->getAllUserTasks();
        return view('client.tasks', compact('tasks'));
    }

    /**
     * Affiche le formulaire de création d'une tâche.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client.tasks.create');
    }

    /**
     * Enregistre une nouvelle tâche.
     *
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        $this->taskService->createTask($request->validated());

        return redirect()->route('client.tasks')
            ->with('success', 'Tâche ajoutée avec succès');
    }

    /**
     * Affiche le formulaire d'édition d'une tâche.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $task = $this->taskService->getTask($id);
        return view('client.tasks.edit', compact('task'));
    }

    /**
     * Met à jour une tâche existante.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $this->taskService->updateTask($id, $request->validated());

        return redirect()->route('client.tasks')
            ->with('success', 'Tâche mise à jour avec succès');
    }

    /**
     * Supprime une tâche.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->taskService->deleteTask($id);

        return redirect()->route('client.tasks')
            ->with('success', 'Tâche supprimée avec succès');
    }

    /**
     * Marque une tâche comme terminée.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete($id)
    {
        $this->taskService->completeTask($id);

        return redirect()->route('client.tasks')
            ->with('success', 'Tâche marquée comme terminée');
    }

    /**
     * Marque une tâche comme en attente.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pending($id)
    {
        $this->taskService->pendingTask($id);

        return redirect()->route('client.tasks')
            ->with('success', 'Tâche marquée comme en attente');
    }
}
