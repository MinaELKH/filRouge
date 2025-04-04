<?php

namespace App\Repositories;

use App\Models\Devis;
use App\Models\Reservation;
use App\Repositories\Contracts\DevisRepositoryInterface;

class DevisRepository implements DevisRepositoryInterface
{
    /**
     * Créer un devis
     */
    public function create(array $data): Devis
    {
        return Devis::create($data);
    }

    /**
     * Récupérer un devis par son ID
     */
    public function find(int $id): Devis
    {
        return Devis::findOrFail($id);
    }

    /**
     * Mettre à jour un devis
     */
    public function update(Devis $devis, array $data): Devis
    {
        $devis->update($data);
        return $devis;
    }

    /**
     * Supprimer un devis
     */
    public function delete(Devis $devis): void
    {
        $devis->delete();
    }

    /**
     * Récupérer tous les devis associés à une réservation
     */
    public function getByReservationId(int $reservationId)
    {
        return Devis::where('reservation_id', $reservationId)->get();
    }
}
