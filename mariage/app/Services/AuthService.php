<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService {
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password): bool {
        $user = $this->userRepository->findByEmail($email);

        if ($user && Hash::check($password, $user->password)) {
            Auth::loginUsingId($user->id);
            return true;
        }

        return false;
    }

    public function register(array $data) {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }


    public function logout() {
        Auth::logout();
    }

    public function checkRoleRedirect($user)
    {

        return match($user->role) {
            'admin'       => 'admin.dashboard',
            'client'      => 'home',
            'prestataire' => 'prestataire.home',
            default       => 'home',
        };
    }
}
