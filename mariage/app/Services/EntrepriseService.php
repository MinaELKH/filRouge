<?php

namespace App\Services;


use App\Repositories\Contracts\EntrepriseRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntrepriseService
{
    protected $entrepriseRepository;

    public function __construct(EntrepriseRepositoryInterface $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }
// affiche les info de l entreprise pour son propore compte
    public function getUserEntreprise($user_id)
    {
        return $this->entrepriseRepository->getByUserId($user_id);
    }


    public function updateOrCreate(array $data)
    {
        $userId = Auth::id();

        // Gérer le téléchargement du logo si présent
        if (isset($data['logo']) && $data['logo']->isValid()) {
            $path = $data['logo']->store('logos', 'public');
            $data['logo'] = $path;
        }

        return $this->entrepriseRepository->updateOrCreate($userId, $data);
    }
}
