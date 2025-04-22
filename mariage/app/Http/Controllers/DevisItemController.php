<?php

namespace App\Http\Controllers;

use App\Models\DevisItem;
use App\Services\DevisItemService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DevisItemController extends Controller
{
    protected $devisItemService;

    public function __construct(DevisItemService $devisItemService)
    {
        $this->devisItemService = $devisItemService;
    }

    public function storeMultiple(Request $request)
    {
        $this->authorize('create', DevisItem::class);
        $items = $request->input('items');

        try {
            $this->devisItemService->addItems($items);
            return response()->json(['message' => 'Éléments de devis ajoutés avec succès.'], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }


}
