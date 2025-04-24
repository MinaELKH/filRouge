<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        // Assurer que seul un utilisateur authentifié peut effectuer ces actions
        $this->middleware('auth:api');

        // Injection du service de réservation
        $this->reservationService = $reservationService;
    }

    /**
     * Créer une nouvelle réservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_date' => 'required|date|after:today',
        ]);

        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        // Créer la réservation via le service
        $data = [
            'user_id' => $user->id, // L'utilisateur qui réserve (client)
            'service_id' => $request->service_id,
            'event_date' => $request->event_date,
            'status' => 'pending', // Le statut initial est "pending"
        ];

        $reservation = $this->reservationService->createReservation($data);

        // Retourner une réponse de succès
        return response()->json([
            'message' => 'Réservation créée avec succès.',
            'reservation' => $reservation
        ], 201);
    }

    /**
     * Afficher la liste des réservations pour l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $role = $user->role; // Le rôle peut être 'client' ou 'prestataire'

        // Récupérer les réservations de l'utilisateur via le service
        $reservations = $this->reservationService->getUserReservations($user->id, $role);

        return response()->json($reservations);
    }

    /**
     * Afficher une réservation spécifique
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Trouver la réservation
        $reservation = $this->reservationService->find($id);

        // Vérifier si l'utilisateur connecté peut voir la réservation
        $this->authorize('view', $reservation);

        return response()->json($reservation);
    }

    /**
     * Mettre à jour le statut de la réservation (par exemple, accepté ou rejeté)
     *
     * @param \App\Models\Reservation $reservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        // Validation du statut
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        // Trouver la réservation
        $reservation = $this->reservationService->find($id);

        // Vérifier si l'utilisateur peut mettre à jour la réservation
        $this->authorize('update', $reservation);

        // Mettre à jour le statut via le service
        $reservationUpdated = $this->reservationService->updateReservation($reservation, ['status' => $request->status]);

        return response()->json([
            'message' => 'Réservation mise à jour avec succès.',
            'reservation' => $reservationUpdated
        ]);
    }


    public function update(Request $request, $id)
    {

        // Trouver la réservation
        $reservation = $this->reservationService->find($id);

        // Vérifier si l'utilisateur peut mettre à jour la réservation
        $this->authorize('update', $reservation);
        $data = $request->validate([
            'event_date' => 'required|date|after:today',
        ]) ;
        // Mettre à jour le statut via le service
        $reservationUpdated = $this->reservationService->updateReservation($reservation, $data);

        return response()->json([
            'message' => 'Réservation mise à jour avec succès.',
            'reservation' => $reservationUpdated
        ]);
    }
    /**
     * Supprimer une réservation
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trouver la réservation
        $reservation = $this->reservationService->find($id);

        // Vérifier si l'utilisateur peut supprimer la réservation
        $this->authorize('delete', $reservation);

        // Supprimer la réservation via le service
        $this->reservationService->deleteReservation($reservation);

        return response()->json([
            'message' => 'Réservation supprimée avec succès.'
        ]);
    }



    public function mesReservations()
    {
        $reservations = auth()->user()->reservations()->with('service')->get();
        return view('client.reservations.index', compact('reservations'));
    }



}
