<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ServiceService;

class FrontHomeController
{
    private $serviceService;
    private $categoryService;
    public function __construct(serviceService $serviceService , CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->serviceService = $serviceService;
    }
    public function index(){

        $data = $this->serviceService->getAllServices();
        $services = $data['services'];
        $categories = $data['categories'];
        $villes = $data['villes'];
       // dd($villes) ;
        // Retourner la vue avec les résultats
        return view('pages.home', compact('services', 'categories', 'villes'));

    }

}
