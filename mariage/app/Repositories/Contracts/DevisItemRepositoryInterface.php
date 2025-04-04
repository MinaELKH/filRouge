<?php


namespace App\Repositories\Contracts ;

use App\Models\DevisItem;

interface DevisItemRepositoryInterface
{
    public function all();

    public function find(int $id): ?DevisItem;

    public function create(array $data): DevisItem;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

  //  public function create(array $data);
    public function createMany(array $data);
}
