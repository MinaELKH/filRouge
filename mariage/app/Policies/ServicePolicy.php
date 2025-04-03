<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;

class ServicePolicy
{
    /**
     * Détermine si un prestataire peut créer un service.
     */
    public function create(User $user)
    {
        return $user->role === 'prestataire';
    }

    /**
     * Détermine si un prestataire peut modifier son propre service.
     */
    public function update(User $user, Service $service)
    {
        return $user->role === 'prestataire' && $user->id === $service->user_id;
    }

    /**
     * Détermine si un prestataire peut supprimer son propre service.
     */
    public function delete(User $user, Service $service)
    {
        return $user->role === 'prestataire' && $user->id === $service->user_id;
    }

    /**
     * Détermine si l'administrateur peut bannir, valider ou archiver un service.
     */
    public function manage(User $user, Service $service)
    {
        return $user->role === 'admin';
    }
}
