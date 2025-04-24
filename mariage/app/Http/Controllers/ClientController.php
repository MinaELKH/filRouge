<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use App\Services\DevisService;
//use App\Services\FavoriteService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $reservationService;
    protected $devisService;
    protected $favoriteService;

    // Injection des services dans le contrôleur
    public function __construct(
        ReservationService $reservationService,
        DevisService $devisService,
     //   FavoriteService $favoriteService
    ) {
        $this->reservationService = $reservationService;
        $this->devisService = $devisService;
        //$this->favoriteService = $favoriteService;
    }

    // Tableau de bord
    public function dashboard()
    {
        return view('client.dashboard');
    }

    // Profil du client
    public function profile()
    {
        // Récupérer les informations du client connecté
        $client = auth()->user();
        return view('client.profile', compact('client'));
    }

    // Tâches du client
    public function tasks()
    {
        // Logique pour récupérer les tâches du client, par exemple les réservations à venir, les actions à faire
        return view('client.tasks');
    }

    // Favoris du client
    public function favorites()
    {
        // Récupérer les services favoris du client via le service
        $favorites = $this->favoriteService->getClientFavorites(auth()->id());
        return view('client.favorites', compact('favorites'));
    }

    // Devis du client
    public function devis()
    {
        // Récupérer les devis du client via le service
        $devis = $this->devisService->getClientDevis(auth()->id());
        return view('client.devis', compact('devis'));
    }

    // Services réservés par le client
    public function reservations()
    {
        // Récupérer les services réservés par le client via le service
        $reservations = $this->reservationService->getClientReservations(auth()->id());
        return view('client.reservations', compact('reservations'));
    }
}
