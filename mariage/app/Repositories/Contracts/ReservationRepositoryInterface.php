<?php
namespace App\Repositories\Contracts ;

use App\Models\Reservation;

interface ReservationRepositoryInterface {
    public function create($data);
    public function getUserReservations($userId);
    public function getPrestataireReservations($userId);
    public function find($id);
    public function update($reservation, $data);
    public function delete($reservation);

    public function findOrCreate(array $data);

    // dashboard admin

    public function countByStatus(string $status): int;
}
