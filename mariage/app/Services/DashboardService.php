<?php

namespace App\Services;

use App\Repositories\Contracts\DashboardRepositoryInterface;


class DashboardService
{
    protected $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getStats($userId)
    {
        return [
            'services_by_category' => $this->dashboardRepository->countServicesByCategory($userId),
            'reservations_by_status' => $this->dashboardRepository->countReservationsByStatus($userId),
            'devis_by_status' => $this->dashboardRepository->countDevisByStatus($userId),
            'revenu_par_devis' => $this->dashboardRepository->getRevenuEstimeParDevis($userId),
        ];
    }
}
