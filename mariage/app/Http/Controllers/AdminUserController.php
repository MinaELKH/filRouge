<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $role = $request->role;

        if (!in_array($role, ['client', 'prestataire'])) {
            abort(404);
        }

        $users = $this->userService->getUsers($search, $role);

        return view('admin.manage_users', compact('users', 'role'));
    }


    public function showPrestataires(Request $request)
    {
        $search = $request->search;
        $users = $this->userService->getUsers($search, 'prestataire');

        return view('admin.manage_prestataires', compact('users'));
    }

    public function showClients(Request $request)
    {
        $search = $request->search;
        $users = $this->userService->getUsers($search, 'client');

        return view('admin.manage_clients', compact('users'));
    }


// Méthode pour bannir un utilisateur
    public function toggleBan($id)
    {
        $user = $this->userService->banirUser($id);

        return redirect()->route('admin.manage_users')->with('success', 'Utilisateur mis à jour avec succès.');
    }
}
