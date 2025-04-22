<?php

namespace App\Services;

use App\Models\Ville;
use App\Repositories\villeRepository;

class villeService
{
    protected $villeRepository ;

    public function __construct(villeRepository $villeRepository)
    {
        $this->villeRepository = $villeRepository;
    }
    public function findById($id){
        return $this->villeRepository->findById($id);

    }
    public function getAll(){
        return  $villes = Ville::all();
    }

}
