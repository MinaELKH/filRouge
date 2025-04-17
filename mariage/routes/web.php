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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


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

