<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// register

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//category


Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']); // Les actions index et show sont publiques, pas d'authentification requise

Route::middleware('auth:api') // Protège ces actions avec l'authentification
->apiResource('categories', CategoryController::class)
    ->only(['store', 'update', 'destroy']);

// service

use App\Http\Controllers\ServiceController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('services', ServiceController::class)
        ->only(['store', 'update', 'destroy']);

    // Route pour que l'admin puisse changer le statut d'un service
    Route::patch('services/{id}/status', [ServiceController::class, 'manage']);
});

// Routes publiques (consultation sans authentification)
Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);
