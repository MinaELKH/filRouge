<?php

namespace App\Services;


use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class AdminDashboardService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected ServiceRepositoryInterface $serviceRepo,
        protected ReservationRepositoryInterface $reservationRepo
    ) {}

    public function getDashboardData(): array
    {
        return [
            'totalClients' => $this->userRepo->countByRole('client'),
            'totalPrestataires' => $this->userRepo->countByRole('prestataire'),
            'pendingReservations' => $this->reservationRepo->countByStatus('pending'),
            'pendingOffers' => $this->reservationRepo->countByStatus('offre-envoyée'),
            'topPrestataires' => $this->userRepo->getTopPrestataires(3),
            'topCategories' => $this->serviceRepo->getTopCategories(3),
            'topServices' => $this->serviceRepo->getTopServices(3),
        ];
    }
}
