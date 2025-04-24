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
    public function getWithRelations(int $id, array $relations): Devis
    {
        return Devis::with($relations)->findOrFail($id);
    }

    public function getByPrestataireId($userId)
    {
        return Devis::whereHas('reservation.service', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['reservation.service', 'reservation.user']) // pour info service/client
        ->latest()
        ->get();
    }

    public function getDevisByClientId($clientId)
    {
        return Devis::whereHas('reservation', function ($query) use ($clientId) {
            $query->where('user_id', $clientId);
        })->get();
    }
}
