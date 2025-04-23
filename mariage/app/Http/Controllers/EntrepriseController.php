<?php

namespace App\Http\Controllers;

use App\Services\EntrepriseService;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    protected $entrepriseService;

    public function __construct(EntrepriseService $entrepriseService)
    {
        $this->entrepriseService = $entrepriseService;
        $this->middleware('auth');
    }

    public function index()
    {
        $entreprise = $this->entrepriseService->getUserEntreprise();
        return view('dashboard', compact('entreprise'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'personne_contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'type_telephone' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048'
        ]);

        $this->entrepriseService->updateEntreprise($validated);

        return redirect()->route('dashboard')->with('success', 'Informations mises à jour avec succès.');
    }

    public function saveOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'personne_contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'type_telephone' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048'
        ]);

        $this->entrepriseService->updateOrCreate($validated);

        return redirect()->route('dashboard')->with('success', 'Informations enregistrées avec succès.');
    }
}
