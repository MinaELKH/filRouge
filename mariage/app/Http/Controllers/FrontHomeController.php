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
     //   $services = 1 ;
        $categories =$this->categoryService->getAll();
      //  $categories = Category::withCount('services')->get();

        return view('pages.home', compact('services','categories'));
    }

}
