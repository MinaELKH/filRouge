<?php


namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $userId = Auth::id(); // ou fixe l'ID à 3 pour test
        $stats = $this->dashboardService->getStats($userId);
        //dd($stats);
        return view('prestataire.dashboard', compact('stats'));
    }
}
