<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DevisItem;

class DevisItemPolicy
{
    /**
     * Détermine si l'utilisateur peut créer un DevisItem.
     */
    public function create(User $user): bool
    {
        return $user->role === 'prestataire';
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour le DevisItem.
     */
    public function update(User $user, DevisItem $devisItem): bool
    {
        return $user->role === 'prestataire';
    }

    /**
     * Détermine si l'utilisateur peut supprimer le DevisItem.
     */
    public function delete(User $user, DevisItem $devisItem): bool
    {
        return $user->role === 'prestataire';
    }
}
