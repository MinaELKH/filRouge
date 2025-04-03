<?php

namespace App\Services;

use App\Repositories\Contracts\DevisRepositoryInterface;
use App\Models\Devis;
use Exception;

class DevisService
{
    protected $devisRepository;

    public function __construct(DevisRepositoryInterface $devisRepository)
    {
        $this->devisRepository = $devisRepository;
    }

    /**
     * Créer un devis pour une réservation
     */
    public function createDevis(array $data): Devis
    {
        // Logique de validation métier ou autres traitements avant la création
        return $this->devisRepository->create($data);
    }

    /**
     * Récupérer un devis par ID
     */
    public function getDevis(int $id): Devis
    {
        return $this->devisRepository->find($id);
    }

    /**
     * Mettre à jour un devis
     */
    public function updateDevis(Devis $devis, array $data): Devis
    {
        // Logique de mise à jour (ex. vérifier le statut du devis)
        return $this->devisRepository->update($devis, $data);
    }

    /**
     * Supprimer un devis
     */
    public function deleteDevis(Devis $devis): void
    {
        $this->devisRepository->delete($devis);
    }

    /**
     * Récupérer les devis d'une réservation
     */
    public function getDevisByReservationId(int $reservationId)
    {
        return $this->devisRepository->getByReservationId($reservationId);
    }
}
