<?php
namespace App\Repositories\Contracts ;
use App\Models\Service;

interface ServiceRepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);

    public function getByCategory($id);

    public function getByVille($id);

    //dashboard admin
    public function getTopCategories(int $limit);
    public function getTopServices(int $limit);
}
