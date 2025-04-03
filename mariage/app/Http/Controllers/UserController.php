<?php
//AuthController.php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
protected $authService;

public function __construct(AuthService $authService)
{
$this->authService = $authService;
}

public function register(Request $request)
{
$validatedData = $request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users',
'password' => 'required|min:6',
'role' => 'required|in:admin,prestataire,client'
]);

$user = $this->authService->register($validatedData);

return response()->json(['message' => 'User registered successfully', 'user' => $user]);
}

public function login(Request $request)
{
$credentials = $request->validate([
'email' => 'required|email',
'password' => 'required'
]);

$user = $this->authService->login($credentials);

return response()->json(['message' => 'Login successful', 'user' => $user]);
}

public function logout()
{
$this->authService->logout();

return response()->json(['message' => 'Logged out successfully']);
}
}
