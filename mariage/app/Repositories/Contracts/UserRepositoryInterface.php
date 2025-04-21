<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public  function create(array $data);
    public function update(array $data, $id);
    public function delete($id);

    public  function findByEmail($email);
    public  function findById($id);
    public  function findByRole($role);
    public  function getUser($user_id);
    public function banir($user_id);


    // dashboard admin
    public function getUsers(mixed $search, mixed $role);
    public function countByRole(string $role): int;
    public function getTopPrestataires(int $limit);


}
