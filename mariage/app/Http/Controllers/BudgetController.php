<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilClient;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    /**
     * Affiche le budget et les dépenses
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $profil = $user->profilClient;

        // Créer le profil s'il n'existe pas
        if (!$profil) {
            $profil = ProfilClient::create(['user_id' => $user->id]);
        }

        // Récupérer les dépenses par service
        $serviceExpenses = Reservation::select(
            'services.id as service_id',
            'services.name as service_name',
            DB::raw('SUM(reservations.amount) as total_spent')
        )
            ->join('services', 'reservations.service_id', '=', 'services.id')
            ->where('reservations.user_id', $user->id)
            ->groupBy('services.id', 'services.name')
            ->orderBy('total_spent', 'desc')
            ->get();

        // Calculer le montant total dépensé
        $totalSpent = $serviceExpenses->sum('total_spent');

        // Mettre à jour le montant dépensé dans le profil
        $profil->budget_spent = $totalSpent;
        $profil->save();

        // Calculer le budget restant
        $budgetRemaining = $profil->budget ? $profil->budget - $totalSpent : 0;

        return view('client.budget', compact('profil', 'serviceExpenses', 'totalSpent', 'budgetRemaining'));
    }

    /**
     * Met à jour le budget de l'utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBudget(Request $request)
    {
        $user = Auth::user();
        $profil = $user->profilClient;

        // Créer le profil s'il n'existe pas
        if (!$profil) {
            $profil = ProfilClient::create(['user_id' => $user->id]);
        }

        $validated = $request->validate([
            'budget' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
        ]);

        $profil->budget = $validated['budget'];
        $profil->save();

        return redirect()->route('client.budget')->with('success', 'Votre budget a été mis à jour avec succès.');
    }
}
