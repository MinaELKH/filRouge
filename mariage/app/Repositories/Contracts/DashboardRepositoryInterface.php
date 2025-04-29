<?php

namespace App\Repositories;

interface DashboardRepositoryInterface
{
    public function countServicesByCategory($userId);
    public function countReservationsByStatus($userId);
    public function countDevisByStatus($userId);
    public function getRevenuEstimeParDevis($userId);
}
