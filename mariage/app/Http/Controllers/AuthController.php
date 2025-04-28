<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\TransientToken;

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


//    public function register(Request $request) {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6|confirmed',
//            'role' => 'required|in:admin,client,prestataire'
//        ]);
//        // Garde seulement les données utiles
//        $data = $request->only(['name', 'email', 'password', 'role']);
//        $user = $this->authService->register($data);
//
//        // Authentifier l'utilisateur directement après inscription
//        Auth::login($user);
//        $view = $this->authService->checkRoleRedirect($user);
//        return view($view , compact('user'));
//    }
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

        // Utiliser la méthode checkRoleRedirect pour obtenir le nom de la route
        $route = $this->authService->checkRoleRedirect($user);

        // Rediriger vers la route au lieu de la vue
        return redirect()->route($route);
    }

    public function logout(Request $request)
    {
        // Vérifier si l'utilisateur est authentifié via Sanctum
        if ($request->user()) {
            // Supprimer tous les tokens associés à l'utilisateur
            $request->user()->tokens->each(function ($token) {
                $token->delete();
            });
        }

        // Si l'utilisateur utilise une session classique (web), on effectue la déconnexion
        Auth::guard('web')->logout(); // Déconnexion de l'utilisateur via la session web

        // Invalidation de la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirection vers la page de connexion ou la page d'accueil
        return redirect('/login'); // ou '/home', selon tes besoins
    }


}
