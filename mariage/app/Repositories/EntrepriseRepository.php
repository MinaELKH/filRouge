<?php

namespace App\Repositories;

use App\Models\Entreprise;
use App\Repositories\Interfaces\EntrepriseRepositoryInterface;

class EntrepriseRepository implements EntrepriseRepositoryInterface
{
    protected $model;

    public function __construct(Entreprise $entreprise)
    {
        $this->model = $entreprise;
    }

    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function update($id, array $data)
    {
        $entreprise = $this->model->find($id);
        $entreprise->update($data);
        return $entreprise;
    }

    public function updateOrCreate($userId, array $data)
    {
        return $this->model->updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
