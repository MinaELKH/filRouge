<?php
namespace App\Services;


use App\Models\Reservation;
use App\Models\Service;
use App\Repositories\Contracts\ReservationRepositoryInterface;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Créer une réservation
     *
     * @param array $data
     * @return Reservation
     */
    public function createReservation(array $data)
    {
        // Vérifier si le service existe et appartient à un prestataire
        $service = Service::findOrFail($data['service_id']);

        // Créer la réservation via le repository
        return $this->reservationRepository->create($data);
    }

    /**
     * Récupérer les réservations d'un utilisateur (client ou prestataire)
     *
     * @param int $userId
     * @param string $role
     * @return mixed
     */
    public function getUserReservations(int $userId, string $role)
    {
        if ($role === 'client') {
            return $this->reservationRepository->getUserReservations($userId);
        }

        if ($role === 'prestataire') {
            return $this->reservationRepository->getPrestataireReservations($userId);
        }

        return null;
    }

    /**
     * Mettre à jour une réservation
     *
     * @param Reservation $reservation
     * @param array $data
     * @return Reservation
     */
    public function updateReservation(Reservation $reservation, array $data)
    {
        return $this->reservationRepository->update($reservation, $data);
    }

    public function updateStatusReservation(Reservation $reservation, array $data)
    {
        return $this->reservationRepository->update($reservation, $data);
    }

    /**
     * Supprimer une réservation
     *
     * @param Reservation $reservation
     * @return void
     */
    public function deleteReservation(Reservation $reservation)
    {
        $this->reservationRepository->delete($reservation);
    }

    /**
     * Trouver une réservation spécifique
     *
     * @param int $id
     * @return Reservation
     */
    public function find($id)
    {
        return $this->reservationRepository->find($id);
    }
}
