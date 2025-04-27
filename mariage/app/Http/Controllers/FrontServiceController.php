<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class FrontServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Afficher tous les services.
     */
    public function index()
    {
        $services = $this->serviceService->getAllServices();
        return view('services.index', compact('services'));
    }

    /**
     * Afficher un service spécifique.
     */
    public function show($id)
    {
        $service = $this->serviceService->getServiceById($id);
        return view('services.show', compact('service'));
    }

    /**
     * @param  $category
     * @return \Illuminate\Http\JsonResponse
     */

    public function getServicesByCategory($id)
    {
        $services = $this->serviceService->getServiceByCategory($id) ;
        return view('services.serviceByCategory', compact('services'));
    }
    public function getServicesByVille($id)
    {
        $services = $this->serviceService->getServiceByVille($id) ;
        return view('services.serviceByCategory', compact('services'));
    }








    //////////////  manage admin
    ///

    public function manage(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,archived',
        ]);

        $service = $this->serviceService->getServiceById($id);

        // Vérifie si l'utilisateur a l'autorisation de gérer le statut
        $this->authorize('manage', $service);

        // Mise à jour du statut
        $service->update(['status' => $request->status]);

        return response()->json(['message' => 'Statut mis à jour avec succès.', 'service' => $service], 200);
    }




}
