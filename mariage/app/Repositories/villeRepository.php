<?php

namespace App\Repositories;

use App\Models\Ville;
use App\Repositories\Contracts\villeRepositoryInterface;

class villeRepository implements VilleRepositoryInterface
{
    public function findById($id){
        $ville = Ville::find($id);
    }
    public function getAllVilles(){
        $villes = Ville::all();
    }

}
