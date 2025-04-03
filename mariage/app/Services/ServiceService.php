<?php

namespace App\Services;

use App\Repositories\Contracts\ServiceRepositoryInterface;


class ServiceService
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAll();
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->getById($id);
    }

    public function createService(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    public function updateService($id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    public function deleteService($id)
    {
        return $this->serviceRepository->delete($id);
    }
}
