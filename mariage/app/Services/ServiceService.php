<?php

namespace App\Services;

use App\Repositories\Contracts\ServiceRepositoryInterface;


class ServiceService
{

    protected $serviceRepository;
    protected $categoryService;
    protected $villeService;

    public function __construct(ServiceRepositoryInterface $serviceRepository , CategoryService $categoryService, VilleService $villeService)
    {
        $this->serviceRepository = $serviceRepository;
        $this->categoryService = $categoryService;
        $this->villeService = $villeService;
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAll();
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->getById($id);
    }

    public function getServiceByCategory($id)
    {
        return $this->serviceRepository->getByCategory($id);
    }
    public function getServiceByVille($id)
    {
        return $this->serviceRepository->getByVille($id);
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

    public function  editService($id){
        $service = $this->serviceRepository->getById($id);
        $categories = $this->categoryService->getAll();
        $villes = $this->villeService->getAll();
        $data = [ 'service'=>$service , 'categories' => $categories , 'villes' => $villes ];
        return $data ;
    }

    public function archive($id)
    {
        $service = $this->serviceRepository->findById($id);
        $service->archived = true;
        $this->serviceRepository->save($service);
    }

    public function desarchive($id)
    {
        $service = $this->serviceRepository->findById($id);
        $service->archived = false;
        $this->serviceRepository->save($service);
    }

}
