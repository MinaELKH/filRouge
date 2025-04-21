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
// Récupérer les critères de recherche et de rôle
        $search = $request->search;
        $role = $request->role;

// Appeler la méthode du service pour récupérer les utilisateurs
        $users = $this->userService->getUsers($search, $role);

// Retourner la vue avec les utilisateurs
        return view('admin.manage_users', compact('users'));
    }

// Méthode pour bannir un utilisateur
    public function toggleBan($id)
    {
        $user = $this->userService->banirUser($id);

        return redirect()->route('admin.manage_users')->with('success', 'Utilisateur mis à jour avec succès.');
    }
}
