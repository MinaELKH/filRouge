<?php


namespace App\Policies;

use App\Models\User;
use App\Models\Devis;

class DevisPolicy
{
    /**
     * Détermine si l'utilisateur peut créer un devis.
     */
    public function create(User $user): bool
    {
        return $user->role === 'prestataire';
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour le devis.
     */
    public function update(User $user, Devis $devis): bool
    {
        return $user->role === 'prestataire' && $devis->prestataire_id === $user->id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer le devis.
     */
    public function delete(User $user, Devis $devis): bool
    {
        return $user->role === 'prestataire' && $devis->prestataire_id === $user->id;
    }

    /**
     * Détermine si l'utilisateur peut voir le devis.
     */
    public function view(User $user, Devis $devis): bool
    {
        return ($user->role === 'prestataire' && $devis->prestataire_id === $user->id) ||
            ($user->role === 'client' && $devis->reservation->client_id === $user->id);
    }
}
