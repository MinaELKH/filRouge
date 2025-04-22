<?php

namespace App\Services;

use App\Repositories\Contracts\DevisItemRepositoryInterface;

use App\Models\DevisItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DevisItemService
{
    protected $devisItemRepository;

    public function __construct(DevisItemRepositoryInterface $devisItemRepository)
    {
        $this->devisItemRepository = $devisItemRepository;
    }

    /**
     * Récupère tous les éléments de devis.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllDevisItems()
    {
        return $this->devisItemRepository->all();
    }

    /**
     * Trouve un élément de devis par son identifiant.
     *
     * @param int $id
     * @return DevisItem|null
     */
    public function findDevisItemById(int $id): ?DevisItem
    {
        return $this->devisItemRepository->find($id);
    }

    /**
     * Crée un nouvel élément de devis.
     *
     * @param array $data
     * @return DevisItem
     */
    public function createDevisItem(array $data): DevisItem
    {
        // Calculer le prix total
        $data['total_price'] = $data['quantity'] * $data['unit_price'];

        return $this->devisItemRepository->create($data);
    }

    /**
     * Met à jour un élément de devis existant.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    /**
     * Met à jour un seul élément de devis par son ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateItem(int $id, array $data)
    {
        $item = $this->findDevisItemById($id);

        if (!$item) {
            return false;
        }

        return $item->update([
            'service_name' => $data['service_name'],
            'quantity'     => $data['quantity'],
            'unit_price'   => $data['unit_price'],
            'total_price'  => $data['quantity'] * $data['unit_price'],
        ]);
    }

    /**
     * Crée un élément de devis lié à un devis donné.
     *
     * @param int $devisId
     * @param array $data
     * @return DevisItem
     */
    public function createItem(int $devisId, array $data): DevisItem
    {
        $data['devis_id'] = $devisId;
        $data['total_price'] = $data['quantity'] * $data['unit_price'];

        return $this->devisItemRepository->create($data);
    }

    /**
     * Supprime un élément de devis.
     *
     * @param int $id
     * @return bool
     */
    public function deleteDevisItem(int $id): bool
    {
        return $this->devisItemRepository->delete($id);
    }

/*
 * ajout massif
 */
    public function addItems(array $items)
    {
        $validator = Validator::make(['items' => $items], [
            'items' => 'required|array',
            'items.*.devis_id' => 'required|exists:devis,id',
            'items.*.service_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $itemsToInsert = array_map(function ($item) {
            return [
                'devis_id' => $item['devis_id'],
                'service_name' => $item['service_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $items);

        return $this->devisItemRepository->createMany($itemsToInsert);
    }
}
