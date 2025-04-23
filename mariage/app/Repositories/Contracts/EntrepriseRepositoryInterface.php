<?php

namespace App\Repositories\Contracts;

interface EntrepriseRepositoryInterface
{
    public function getByUserId($userId);
    public function create(array $data);
    public function update($id, array $data);
    public function updateOrCreate($userId, array $data);
}
