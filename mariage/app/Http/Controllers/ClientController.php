<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Devis;
use App\Models\Favorite;

class ClientController extends Controller
{
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
        // Récupérer les services favoris du client
        $favorites = Favorite::where('user_id', auth()->id())->get();
        return view('client.favorites', compact('favorites'));
    }

    // Devis du client
    public function devis()
    {
        // Récupérer les devis du client
        $devis = Devis::where('client_id', auth()->id())->get();
        return view('client.devis', compact('devis'));
    }

    // Services réservés par le client
    public function reservations()
    {
        // Récupérer les services réservés par le client
        $reservations = Reservation::where('client_id', auth()->id())->get();
        return view('client.reservations', compact('reservations'));
    }
}

