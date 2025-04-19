<?php

use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AuthController;
// Page d'inscription
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Actions d'envoi des formulaires


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



// redirection apres authentification :
Route::middleware(['auth'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    // Espace Client
    Route::view('/client/home', 'client.home')
        ->name('client.home');

    // Dashboard Prestataire
    Route::view('/prestataire/home', 'prestataire.home')
        ->name('prestataire.home');
});

Route::view('/prestataire/message', 'prestataire.crud_message')
    ->name('prestataire.message');


Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{partnerId}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.store');
});


use App\Http\Controllers\FrontServiceController;

Route::get('/home', [FrontHomeController::class, 'index'])->name('home');

Route::get('services', [FrontServiceController::class, 'index']);
Route::get('services/{id}', [FrontServiceController::class, 'show']);
// affiche les services d une category X
Route::get('categories/{categoryId}/services', [FrontServiceController::class, 'getServicesByCategory']);


Route::post('/messages/create', [MessageController::class, 'create'])->name('messages.create');

Route::get('/test', function () {
    return view('services.service'); // correspond à resources/views/noti-club.blade.php
});


Route::get('/services/{id}', [FrontServiceController::class, 'show'])->name('services.show');

