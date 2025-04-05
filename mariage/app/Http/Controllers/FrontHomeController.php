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
        $services = $this->serviceService->getAllServices();
        $categories =$this->categoryService->getAll();

        return view('pages.home', compact('services','categories'));
    }

}
