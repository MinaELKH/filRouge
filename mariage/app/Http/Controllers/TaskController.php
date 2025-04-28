<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    protected $taskService;
    protected $categoryService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService , CategoryService $categoryService)
    {
        $this->taskService = $taskService;
        $this->categoryService = $categoryService;
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
        $categories = $this->categoryService->getAll() ;
        return view('client.tasks.index', compact('tasks' , 'categories'));
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $this->taskService->createTask($validatedData);

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
        $categories = $this->categoryService->getAll() ;
        return view('client.tasks.edit', compact('task' , 'categories'));
    }

    /**
     * Met à jour une tâche existante.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,completed',
        ]);

        $this->taskService->updateTask($id, $validatedData);

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
