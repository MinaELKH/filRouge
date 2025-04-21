<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;

class AdminDashboardController
{
    public function __construct(protected AdminDashboardService $dashboardService) {}

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('admin.dashboard', $data);
    }
}
