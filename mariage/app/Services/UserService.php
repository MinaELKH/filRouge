<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
protected $userRepository;

public function __construct(UserRepositoryInterface $userRepository)
{
$this->userRepository = $userRepository;
}

public function getUsers($search = null, $role = null)
{
return $this->userRepository->getUsers($search, $role);
}

// Méthode pour bannir un utilisateur
public function banirUser($user_id)
{
return $this->userRepository->banir($user_id);
}

    public function getClientById($client_id)
    {
        return $this->userRepository->getUser($client_id);

    }
}
