<?php

namespace App\Repositories;

use App\Models\DevisItem;
use App\Repositories\Contracts\DevisItemRepositoryInterface;


class DevisItemRepository implements DevisItemRepositoryInterface
{
    public function all()
    {
        return DevisItem::all();
    }

    public function find(int $id): ?DevisItem
    {
        return DevisItem::find($id);
    }

    public function create(array $data): DevisItem
    {
        return DevisItem::create($data);
    }

    public function createMany(array $data)
    {
        return DevisItem::insert($data);
    }

    public function update(int $id, array $data): bool
    {
        $devisItem = $this->find($id);
        if ($devisItem) {
            return $devisItem->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $devisItem = $this->find($id);
        if ($devisItem) {
            return $devisItem->delete();
        }
        return false;
    }
}
