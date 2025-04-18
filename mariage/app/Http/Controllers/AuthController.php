<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    // AuthController.php

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Vérification du rôle et redirection
            $routeName = $this->authService->checkRoleRedirect($user);
            return redirect()->route($routeName);
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }


    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,client,prestataire'
        ]);
        // Garde seulement les données utiles
        $data = $request->only(['name', 'email', 'password', 'role']);
        $user = $this->authService->register($data);

        // Authentifier l'utilisateur directement après inscription
        Auth::login($user);
        $view = $this->authService->checkRoleRedirect($user);
        return view($view , compact('user'));
    }


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }



}
