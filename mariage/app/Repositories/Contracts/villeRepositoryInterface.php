<?php

namespace App\Repositories\Contracts;

interface villeRepositoryInterface
{
    public function findById($id);
    public function getAll();

}
