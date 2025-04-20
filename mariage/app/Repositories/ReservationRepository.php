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
    public function findOrCreate(array $data)
    {
        $reservation = Reservation::where([
            'user_id' => $data['user_id'],
            'service_id' => $data['service_id'],
            'event_date' => $data['event_date'],
        ])->first();

        if (!$reservation) {
            $reservation = Reservation::create([
                'user_id' => $data['user_id'],
                'service_id' => $data['service_id'],
                'event_date' => $data['event_date'],
                'status' => 'pending',
            ]);
        }

        return $reservation;
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
