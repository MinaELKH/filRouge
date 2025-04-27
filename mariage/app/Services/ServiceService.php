<?php

namespace App\Services;

use App\Repositories\Contracts\ServiceRepositoryInterface;


class ServiceService
{

    protected $serviceRepository;
    protected $categoryService;
    protected $villeService;
    private $entrepriseService;

    public function __construct(ServiceRepositoryInterface $serviceRepository , CategoryService $categoryService, VilleService $villeService , EntrepriseService $entrepriseService)
    {
        $this->serviceRepository = $serviceRepository;
        $this->categoryService = $categoryService;
        $this->villeService = $villeService;
        $this->entrepriseService = $entrepriseService;
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAll();
    }

    public function getServiceById($id)
    {
        $service = $this->serviceRepository->getById($id);
        $service->entreprise = $this->entrepriseService->getUserEntreprise($service->user_id);
        return $service;
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

    public function  createViewService(){
        $categories = $this->categoryService->getAll();
        $villes = $this->villeService->getAll();
        $data = [  'categories' => $categories , 'villes' => $villes ];
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


    public function myServicesPrestataire($user)
    {

        $services = $this->serviceRepository->myServicesPrestataire($user)  ;      // Passe la variable $services à la vue
        return $services;
    }



}
