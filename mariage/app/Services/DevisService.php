<?php

namespace App\Services;

use App\Repositories\Contracts\DevisRepositoryInterface;
use App\Models\Devis;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $data['status']='pending';
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


    public function generateDevisPdf($devisId)
    {
        // Récupérer le devis avec ses relations
        //$devis = Devis::with(['client', 'prestataire', 'service', 'category', 'devisItems'])->findOrFail($devisId);

        $devis = Devis::with(['reservation.client', 'reservation.service.user','reservation.service' , 'reservation.service.category', 'devisItems'])->findOrFail($devisId);

        $client = $devis->client;
        $service = $devis->reservation->service;
        $prestataire = $service->user;
        $categorie = $service->category;
        // Calculer le montant total des items
        $totalAmount = $devis->devisItems->sum('amount');

        // Générer le PDF à partir de la vue Blade
        $pdf = Pdf::loadView('devis.pdf', compact('devis', 'totalAmount'));

        return $pdf->download('devis_' . $devis->id . '.pdf');

    }

    public function getDevisWithItems(int $id): Devis
    {
        // présuppose que ton repository expose une méthode
        // getWithRelations($id, ['devisItems', 'reservation.client', 'reservation.service'])
        return $this->devisRepository->getWithRelations($id, [
            'devisItems',               // items du devis
            'reservation.client',       // infos client
            'reservation.service.user', // prestataire
            'reservation.service.category'
        ]);
    }

}
