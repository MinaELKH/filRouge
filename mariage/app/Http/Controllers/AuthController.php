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

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Sécurité contre les attaques de session fixation
            return redirect()->intended('/dashboard'); // ou autre route
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
        $view = $this->authService->checkRoleRedirecte($user);
        return redirect('/dashboard');
    }


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }



}
