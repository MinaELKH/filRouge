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
}
