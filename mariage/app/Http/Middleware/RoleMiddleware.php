<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est authentifié et possède le rôle requis
        if (!auth()->check() || auth()->user()->role !== $role) {
            // Rediriger ou afficher un message d'erreur si l'utilisateur n'a pas le rôle
            return redirect('/')->with('error', 'Accès refusé');
        }

        return $next($request);
    }
}

