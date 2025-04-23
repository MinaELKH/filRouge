<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;


class ServiceRepository implements ServiceRepositoryInterface
{
    public function getAll()
    {
        return Service::with(['category', 'user', 'ville'])->get();
    }

    public function getById(int $id)
    {
        return Service::with(['category', 'user', 'ville'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Service::create($data);
    }

    public function update(int $id, array $data)
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }

    public function delete(int $id)
    {
        $service = Service::findOrFail($id);
        return $service->delete();
    }

    public function getByCategory($id)
    {
        return Service::where('category_id', $id)->paginate(6);
    }

    public function getByVille($id)
    {
        return Service::where('ville_id', $id)->get();
    }


    public function getTopCategories(int $limit)
    {
        return Service::select('categories.name as category_name', \DB::raw('count(*) as total'))
            ->join('categories', 'services.category_id', '=', 'categories.id')  // Jointure avec la table des catégories
            ->groupBy('categories.name', 'categories.id')  // Grouper par nom et ID de la catégorie pour éviter les erreurs
            ->orderByDesc('total')
            ->take($limit)
            ->get();
    }


    // Méthode pour obtenir les services les plus populaires
    public function getTopServices(int $limit)
    {
        return Service::withCount('reservations')  // Utilisation de `withCount` pour compter les réservations
        ->orderByDesc('reservations_count')  // Ordre décroissant par le nombre de réservations
        ->take($limit)  // Limiter le nombre de résultats retournés
        ->get();
    }

    public function findById($id)
    {
        return Service::findOrFail($id);
    }

    public function save(Service $service)
    {
        $service->save();
    }


    public function myServicesPrestataire($user)
    {

        $services = Service::with(['category', 'ville'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Passe la variable $services à la vue
        return $services;
    }
}
