<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\DevisItemController;
use App\Http\Controllers\MessageController;
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

//
// service
//

use App\Http\Controllers\FrontServiceController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('services', FrontServiceController::class)
        ->only(['store', 'update', 'destroy']);

    // Route pour que l'admin puisse changer le statut d'un service
    Route::patch('services/{id}/status', [FrontServiceController::class, 'manage']);
});

// Routes publiques (consultation sans authentification)
Route::get('services', [FrontServiceController::class, 'index']);
Route::get('services/{id}', [FrontServiceController::class, 'show']);
// affiche les services d une category X
Route::get('categories/{categoryId}/services', [FrontServiceController::class, 'getServicesByCategory']);


// affiche les services d une category X
Route::get('villes/{villeId}/services', [FrontServiceController::class, 'getServicesByVille']);


//
// comment
//
Route::middleware('auth:api')->group(function () {
    // Ajouter un commentaire sur un service
    Route::post('services/{service}/comments', [CommentController::class, 'store']);

    // Modifier un commentaire
    Route::put('comments/{comment}', [CommentController::class, 'update']);

    // Supprimer un commentaire
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

    // Signaler un commentaire
    Route::post('comments/{comment}/report', [CommentController::class, 'report']);
});


// reservation
use App\Http\Controllers\ReservationController;

Route::middleware('auth:api')->group(function () {
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::get('reservations/{id}', [ReservationController::class, 'show']);
    Route::put('reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy']);
    Route::patch('reservations/{id}/status', [ReservationController::class, 'updateStatus']);
});


//devis

Route::middleware('auth:api')->group(function () {
    Route::apiResource('devis', DevisController::class);
    Route::get('devis/reservation/{reservationId}', [DevisController::class, 'getByReservation']);
    Route::get('devis/{id}/pdf', [DevisController::class, 'generateDevisPdf']);

});


//devisItem
Route::middleware('auth:api')->group(function () {
    Route::post('/devis-items', [DevisItemController::class, 'storeMultiple']);

});



Route::post('/messages/create', [MessageController::class, 'create'])->name('messages.create');

