<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
        return response()->json($this->serviceService->getAllServices(), 200);
    }

    /**
     * Afficher un service spécifique.
     */
    public function show($id)
    {
        return response()->json($this->serviceService->getServiceById($id), 200);
    }

    /**
     * @param  $category
     * @return \Illuminate\Http\JsonResponse
     */

    public function getServicesByCategory($id)
    {
        return response()->json($this->serviceService->getServiceByCategory($id) , 200) ;
    }
    public function getServicesByVille($id)
    {
        return response()->json($this->serviceService->getServiceByVille($id) , 200) ;
    }


    public function store(Request $request)
    {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'cover_image' => 'required|string',
            'gallery'     => 'nullable|json',
            'category_id' => 'required|exists:categories,id',
            'ville_id'    => 'required|exists:villes,id',
        ]);

        return response()->json($this->serviceService->createService(array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => 'pending',
        ])), 201);
    }

    public function update(Request $request, $id)
    {
        $service = $this->serviceService->getServiceById($id);
        $this->authorize('update', $service);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric',
            'cover_image' => 'sometimes|required|string',
            'gallery'     => 'nullable|json',
            'category_id' => 'sometimes|required|exists:categories,id',
            'ville_id'    => 'sometimes|required|exists:villes,id',
        ]);

        return response()->json($this->serviceService->updateService($id, $validated), 200);
    }

    public function destroy($id)
    {
        $service = $this->serviceService->getServiceById($id);
        $this->authorize('delete', $service);

        $this->serviceService->deleteService($id);
        return response()->json(['message' => 'Service supprimé avec succès'], 200);
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

        return redirect()->route('admin.manage_services')->with('success', 'services modifiée avec succès');
    }


    public function adminIndex()
    {
        $services = Service::with(['category', 'user', 'ville'])
            ->orderByDesc('created_at') // Tri décroissant
            ->get();

        return view('admin.manage_services', compact('services'));
    }




}
