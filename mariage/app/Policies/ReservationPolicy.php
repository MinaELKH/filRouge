<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
use HandlesAuthorization;

// Seul un utilisateur de type "client" peut créer une réservation
public function create(User $user)
{
return $user->role === 'client';
}

// Seul le prestataire du service peut accepter/rejeter la réservation
public function update(User $user, Reservation $reservation)
{
    return $user->id === $reservation->service->user_id
        || ($user->id === $reservation->user_id && $reservation->status === 'pending');
}

// Un admin peut gérer toutes les réservations
public function manage(User $user)
{
return $user->role === 'admin';
}
}
