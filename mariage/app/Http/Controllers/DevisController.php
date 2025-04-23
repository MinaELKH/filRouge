<?php

namespace App\Http\Controllers;

use App\Models\Devis;

use App\Services\DevisItemService;
use App\Services\DevisService;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    protected $devisService;
    private $devisItemService;

    public function __construct(DevisService $devisService , DevisItemService $devisItemService)
    {
       //$this->middleware('auth:api');
        $this->devisService = $devisService;
        $this->devisItemService = $devisItemService;
    }

//    public function store(Request $request)
//    {
//        $this->authorize('create', Devis::class);
//
//        $data = $request->validate([
//            'reservation_id' => 'required|exists:reservations,id',
//            'total_amount'   => 'required|numeric',
//        ]);
//
//        $devis = $this->devisService->createDevis($data);
//
//        return response()->json([
//            'message' => 'Devis créé avec succès.',
//            'devis'   => $devis
//        ], 201);
//    }

    public function store(Request $request)
    {
        $this->authorize('create', Devis::class);

        $data = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'total_amount'   => 'required|numeric',
            'items' => 'nullable|array',
            'items.*.service_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        // 1. Création du devis
        $devis = $this->devisService->createDevis([
            'reservation_id' => $data['reservation_id'],
            'total_amount' => $data['total_amount'],
        ]);

        // 2. Création des éléments de devis s’ils existent
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->devisItemService->createItem($devis->id, $item);
            }
        }

        return redirect()
            ->route('devis.index', $devis->id)
            ->with('success', 'Devis créé avec succès.');
    }


    public function generateDevisPdf($devisId)
    {
        return $this->devisService->generateDevisPdf($devisId);
    }





    public function update(Request $request, $id)
    {
        $devis = $this->devisService->getDevis($id);

        $data = $request->validate([
            'total_amount' => 'nullable|numeric',
            'items'        => 'nullable|array',
            'items.*.service_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
            'items.*.id'           => 'nullable|exists:devis_items,id',
            'deleted_item_ids'     => 'nullable|array',
            'deleted_item_ids.*'   => 'exists:devis_items,id',
        ]);

        // 1. Mise à jour du devis (montant par exemple)
        $devisUpdated = $this->devisService->updateDevis($devis, $data);

        // 2. Mise à jour des éléments existants + ajout de nouveaux
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                if (isset($item['id'])) {
                    $this->devisItemService->updateItem($item['id'], $item); // méthode update par ID
                } else {
                    $this->devisItemService->createItem($devis->id, $item); // méthode pour créer un nouvel item
                }
            }
        }

        // 3. Suppression des éléments supprimés
        if (!empty($data['deleted_item_ids'])) {
            $this->devisItemService->deleteItems($data['deleted_item_ids']);
        }

        return redirect()
            ->back()
            ->with('success', 'Devis et ses éléments mis à jour avec succès.');
    }




    public function destroy($id)
    {
        $devis = $this->devisService->getDevis($id);
        //$this->authorize('delete', $devis);

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
        $devis = $this->devisService->getDevisWithItems((int) $id);


        return view('devis.show', compact('devis'));
    }
    public function createPage($id)
    {

       $this->devisService->createPage($id) ;


        return view('devis.show', compact(''));
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
    public function DevisByPrestataire()
    {
        $devisList = $this->devisService->getDevisByPrestataire(auth()->id());
    //  dd($devisList);
        return view('devis.devisPrestataire', compact('devisList'));
    }

    public function edit($id)
    {
        $devis = $this->devisService->getDevisWithItems($id);
        //dd($devis);

      //  $this->authorize('update', $devis);

        return view('devis.edit', compact('devis'));
    }


}
