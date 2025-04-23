<?php

namespace App\Services;

use App\Repositories\Interfaces\EntrepriseRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntrepriseService
{
    protected $entrepriseRepository;

    public function __construct(EntrepriseRepositoryInterface $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    public function getUserEntreprise()
    {
        return $this->entrepriseRepository->getByUserId(Auth::id());
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
