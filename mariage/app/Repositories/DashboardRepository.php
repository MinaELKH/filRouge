<?php

namespace App\Repositories;

use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function countServicesByCategory($userId)
    {
        return DB::table('services as s')
            ->join('categories as c', 's.category_id', '=', 'c.id')
            ->where('s.user_id', $userId)
            ->select('c.name as categorie', DB::raw('COUNT(s.id) as nbService'))
            ->groupBy('c.name')
            ->get();
    }


    public function countReservationsByStatus($userId)
    {
        return DB::table('reservations as r')
            ->join('services as s', 'r.service_id', '=', 's.id')
            ->where('s.user_id', $userId)
            ->select('r.status', DB::raw('count(*) as nbReservation'))
            ->groupBy('r.status')
            ->get();
    }

    public function countDevisByStatus($userId)
    {
        return DB::table('devis as d')
            ->join('reservations as r', 'd.reservation_id', '=', 'r.id')
            ->join('services as s', 'r.service_id', '=', 's.id')
            ->where('s.user_id', $userId)
            ->select('d.status', DB::raw('count(*) as nbDevis'))
            ->groupBy('d.status')
            ->get();
    }

    public function getRevenuEstimeParDevis($userId)
    {
        return DB::table('devis_items as dt')
            ->join('devis as d', 'd.id', '=', 'dt.devis_id')
            ->join('reservations as r', 'r.id', '=', 'd.reservation_id')
            ->join('services as s', 's.id', '=', 'r.service_id')
            ->where('s.user_id', $userId)
            ->select(
                'dt.devis_id',
                'd.status',
                DB::raw('SUM(dt.quantity * dt.unit_price) as revenuEstime')
            )
            ->groupBy('dt.devis_id', 'd.status')
            ->get();
    }
}
