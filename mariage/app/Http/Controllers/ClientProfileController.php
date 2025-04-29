<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Ville;
use App\Models\ProfilClient;

class ClientProfileController extends Controller
{
    /**
     * Show the client profile form
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $profilClient = $user->profilClient;
        $villes = Ville::orderBy('name')->get();
       // dd($villes);
        return view('client.profile', compact('user', 'profilClient', 'villes'));
    }

    /**
     * Update the client profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Le mot de passe actuel est incorrect.');
                }
            }],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'ville_id' => ['nullable', 'exists:villes,id'],
            'date_event' => ['nullable', 'date'],
            'nombre_invites' => ['nullable', 'integer', 'min:0'],
            'budget' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
        ]);

        // Mettre à jour l'utilisateur
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Mettre à jour ou créer le profil client
        $profilData = [
            'ville_id' => $validated['ville_id'] ?? null,
            'date_event' => $validated['date_event'] ?? null,
            'nombre_invites' => $validated['nombre_invites'] ?? null,
        ];

        if ($request->filled('budget')) {
            $profilData['budget'] = $validated['budget'];
        }

        ProfilClient::updateOrCreate(
            ['user_id' => $user->id],
            $profilData
        );

        return redirect()->route('client.profile')->with('success', 'Votre profil a été mis à jour avec succès.');
    }


    /**
     * Show the client dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $profilClient = $user->profilClient;

        // Récupérer les statistiques pour le dashboard
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $pendingTasks = $totalTasks - $completedTasks;

        $daysToEvent = null;
        if ($profilClient && $profilClient->date_event) {
            $daysToEvent = now()->diffInDays($profilClient->date_event, false);
        }

        $recentMessages = $user->receivedMessages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $favoriteProviders = $user->favorites()
            ->with('provider')
            ->take(4)
            ->get();

        $upcomingReservations = $user->reservations()
            ->with('provider')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('client.dashboard', compact(
            'profilClient',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'daysToEvent',
            'recentMessages',
            'favoriteProviders',
            'upcomingReservations'
        ));
    }
}
