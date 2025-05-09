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
    public function findOrCreateReservation(array $data)
    {
        return $this->reservationRepository->findOrCreate($data);
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

    public function getReservationById($id)
    {
        return $this->reservationRepository->find($id);
    }

    public function getClientReservations(int|string|null $id)
    {
        // Si l'id est fourni, on l'utilise pour récupérer les réservations d'un client spécifique
        if ($id) {
            return $this->reservationRepository->getUserReservations($id);
        }

        // Si aucun id n'est fourni, on récupère les réservations de l'utilisateur connecté (auth)
        return $this->reservationRepository->getUserReservations(auth()->id());
    }

    public function prestataireReservations($userId)
    {

        $reservations = $this->reservationRepository->getPrestataireReservations($userId);

         return $reservations ;
    }


}
