<?php

use App\Http\Controllers\DevisController;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
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


Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');





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





Route::middleware('auth')->get('/messages/{partnerId?}', [MessageController::class,'index'])
    ->where('partnerId','[0-9]+')
    ->name('messages.index');
Route::middleware('auth')->post('/messages/{partnerId}/reply', [MessageController::class,'sendReply'])
    ->name('messages.reply');



use App\Http\Controllers\FrontServiceController;

Route::get('/home', [FrontHomeController::class, 'index'])->name('home');

Route::get('services', [FrontServiceController::class, 'index']);
Route::get('services/{id}', [FrontServiceController::class, 'show']);
// affiche les services d une category X
Route::get('categories/{categoryId}/services', [FrontServiceController::class, 'getServicesByCategory']);

Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
//Route::post('/messages/create', [MessageController::class, 'create'])->name('messages.create');

Route::get('/test', function () {
    return view('services.service'); // correspond à resources/views/noti-club.blade.php
});


Route::get('/services/{id}', [FrontServiceController::class, 'show'])->name('services.show');




///// devis

Route::get('/devis/{id}/show', [DevisController::class, 'showPage'])
    ->middleware('auth')
    ->name('devis.page');
Route::post('/devis/{id}/confirm', [DevisController::class, 'confirm'])
    ->middleware('auth')
    ->name('devis.confirm');

Route::post('/messages/send-devis-by-reservation/{reservation}', [MessageController::class, 'sendDevisByReservation'])
    ->name('messages.sendDevisByReservation');

Route::get('/devis/{devi}', [DevisController::class, 'showPage'])
    ->name('devis.show');


// espace admin :
// categorie

use App\Http\Controllers\CategoryController;

Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/categories/manage', [CategoryController::class, 'index'])->name('admin.manage_categorie');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});


// manage service
Route::get('/admin/services', [ServiceController::class, 'adminIndex'])->name('admin.services.index');
Route::patch('/admin/services/{id}/status', [ServiceController::class, 'manage'])->name('admin.services.status');
