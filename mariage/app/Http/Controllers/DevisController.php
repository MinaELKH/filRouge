<?php

namespace App\Http\Controllers;

use App\Models\Devis;

use App\Services\DevisService;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    protected $devisService;

    public function __construct(DevisService $devisService)
    {
        $this->middleware('auth:api');
        $this->devisService = $devisService;
    }

    public function store(Request $request)
    {
        $this->authorize('create', Devis::class);

        $data = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'total_amount'   => 'required|numeric',
        ]);

        $devis = $this->devisService->createDevis($data);

        return response()->json([
            'message' => 'Devis créé avec succès.',
            'devis'   => $devis
        ], 201);
    }


    public function generateDevisPdf($devisId)
    {
        return $this->devisService->generateDevisPdf($devisId);
    }

    public function show($id)
    {
        $devis = $this->devisService->getDevis($id);
        $this->authorize('view', $devis);

        return response()->json($devis);
    }

    public function update(Request $request, $id)
    {
        $devis = $this->devisService->getDevis($id);
        $this->authorize('update', $devis);

        $data = $request->validate([
            'status'       => 'required|in:pending,approved,rejected',
            'total_amount' => 'nullable|numeric'
        ]);

        $devisUpdated = $this->devisService->updateDevis($devis, $data);

        return response()->json([
            'message' => 'Devis mis à jour avec succès.',
            'devis'   => $devisUpdated
        ]);
    }

    public function destroy($id)
    {
        $devis = $this->devisService->getDevis($id);
        $this->authorize('delete', $devis);

        $this->devisService->deleteDevis($devis);

        return response()->json([
            'message' => 'Devis supprimé avec succès.'
        ]);
    }

    public function getByReservation($reservationId)
    {
        $devis = $this->devisService->getDevisByReservationId($reservationId);

        // Filtrer les devis que le client est autorisé à voir
        $devis = $devis->filter(function ($devis) {
            return auth()->user()->can('view', $devis);
        });

        return response()->json($devis);
    }

    public function showPage($id)
    {
        $devis = $this->devisService->getDevis($id);
        $this->authorize('view', $devis);

        return view('devis.show', compact('devis'));
    }


    public function confirm($id)
    {
        $devis = $this->devisService->getDevis($id);
        $this->authorize('update', $devis);

        // Mettre à jour le devis en 'approved'
        $this->devisService->updateDevis($devis, ['status' => 'approved']);

        // Redirection vers le paiement (à adapter)
        return redirect()->route('paiement.page', ['devis_id' => $id]);
    }

}
