<?php

namespace App\Repositories\Contracts;

use App\Models\Devis;

interface DevisRepositoryInterface
{
    /**
     * Créer un devis
     */
    public function create(array $data): Devis;

    /**
     * Récupérer un devis par son ID
     */
    public function find(int $id): Devis;

    /**
     * Mettre à jour un devis
     */
    public function update(Devis $devis, array $data): Devis;

    /**
     * Supprimer un devis
     */
    public function delete(Devis $devis): void;

    /**
     * Récupérer tous les devis associés à une réservation
     */
    public function getByReservationId(int $reservationId);

    public function getWithRelations(int $id, array $relations): Devis;

    public function getDevisByClientId($clientId);
}
