<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Service;
use App\Repositories\Contracts\ReservationRepositoryInterface;


class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * Créer une réservation
     */
    public function create($data)
    {
        return Reservation::create($data);
    }

    /**
     * Récupérer toutes les réservations pour un utilisateur
     */
    public function getUserReservations($userId)
    {
        return Reservation::where('user_id', $userId)->get();
    }

    /**
     * Récupérer les réservations pour un prestataire
     */
    public function getPrestataireReservations($userId)
    {
        return Reservation::whereHas('service', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    /**
     * Afficher une réservation spécifique
     */
    public function find($id)
    {
        return Reservation::findOrFail($id);
    }

    /**
     * Mettre à jour une réservation
     */
    public function update($reservation, $data)
    {
        $reservation->update($data);
        return $reservation;
    }

    /**
     * Supprimer une réservation
     */
    public function delete($reservation)
    {
        $reservation->delete();
    }
}
