<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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
//    Route::view('/prestataire/home', 'prestataire.home')
//        ->name('prestataire.home');


    Route::get('/prestataire/home', [EntrepriseController::class,'index'])
        ->name('prestataire.home');
});





Route::middleware('auth')->get('/messages/{partnerId?}', [MessageController::class,'index'])
    ->where('partnerId','[0-9]+')
    ->name('messages.index');
Route::middleware('auth')->post('/messages/{partnerId}/reply', [MessageController::class,'sendReply'])
    ->name('messages.reply');





Route::get('/home', [FrontHomeController::class, 'index'])->name('home');

Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);
// affiche les services d une category X
Route::get('categories/{categoryId}/services', [ServiceController::class, 'getServicesByCategory']);
// cette fonction cree la premiere message avec reservation
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
//Route::post('/messages/create', [MessageController::class, 'create'])->name('messages.create');

Route::get('/test', function () {
    return view('services.service'); // correspond à resources/views/noti-club.blade.php
});


Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');




///// devis

Route::get('/devis/{id}/show', [DevisController::class, 'showPage'])
    ->middleware('auth')
    ->name('devis.page');
Route::post('/devis/{id}/confirm', [DevisController::class, 'confirm'])
    ->middleware('auth')
    ->name('devis.confirm');

Route::post('/messages/send-devis-by-reservation/{reservation}', [MessageController::class, 'sendDevisByReservation'])
    ->name('messages.sendDevisByReservation');



Route::get('/messages/reservation/{reservationId}', [MessageController::class, 'index'])->name('messages.by.reservation');
Route::post('/messages/reservation/{reservationId}/reply', [MessageController::class, 'sendReply'])->name('messages.reply.by.reservation');


Route::get('/devis/{devi}', [DevisController::class, 'showPage'])
    ->name('devis.show');
Route::get('devis/{id}/pdf', [DevisController::class, 'generateDevisPdf'])->name('devis.pdf');

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
Route::get('/admin/services', [ServiceController::class, 'adminIndex'])->name('admin.manage_services');
Route::patch('/admin/services/{id}/status', [ServiceController::class, 'manage'])->name('admin.services.status');



// manage users

use App\Http\Controllers\AdminUserController;

Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.manage_users');
    Route::patch('/admin/users/{id}/ban', [AdminUserController::class, 'toggleBan'])->name('admin.users.toggleBan');
    Route::get('/admin/users/prestataires', [AdminUserController::class, 'showPrestataires'])->name('admin.manage_prestataires');
    Route::get('/admin/users/clients', [AdminUserController::class, 'showClients'])->name('admin.manage_clients');


});


// dashboard admin

use App\Http\Controllers\AdminDashboardController;

Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});



// espace prestataire

Route::middleware(['auth'])->group(function () {
    Route::get('/prestataire/mes-services', [ServiceController::class, 'myServices'])->name('prestataire.services');
});

Route::get('/prestataire/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/prestataire/services', [ServiceController::class, 'store'])->name('service.store');



Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('edite_service');

Route::patch('/services/{id}/update', [ServiceController::class, 'update'])->name('service.update');
Route::patch('/services/{id}/archive', [ServiceController::class, 'archive'])->name('service.archive');
Route::patch('/services/{id}/desarchive', [ServiceController::class, 'desarchive'])->name('services.desarchive');




// affichage des devis par prestataires

Route::get('/devisPrestataire', [DevisController::class, 'DevisByPrestataire'])->name('devisPrestataire');
Route::get('/devis/{id}/edit', [DevisController::class, 'edit'])->name('devis.edit');
Route::put('/devis/{id}', [DevisController::class, 'update'])->name('devis.update');
Route::get('/devis/create/{id}', [DevisController::class, 'createPage'])->name('devis.create'); // affichage de page
Route::post('/devis/store', [DevisController::class, 'store'])->name('devis.store');

// reservation prestatire
Route::get('/prestataire/reservations', [ReservationController::class, 'prestataireReservations'])->name('prestataire.reservations');

Route::put('/prestataire/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])
    ->name('prestataire.reservations.update-status');

// entreprise
Route::get('/dashboard', [App\Http\Controllers\EntrepriseController::class, 'index'])->name('dashboard');
Route::post('/entreprise/save', [App\Http\Controllers\EntrepriseController::class, 'saveOrUpdate'])->name('entreprise.save');


//client espace
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::get('/client/tasks', [ClientController::class, 'tasks'])->name('client.tasks');
    Route::get('/client/favorites', [ClientController::class, 'favorites'])->name('client.favorites');
    Route::get('/client/devis', [ClientController::class, 'devis'])->name('client.devis');
    Route::get('/client/reservations', [ClientController::class, 'reservations'])->name('client.reservations');
});





// task pour le client
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('client.tasks');
    Route::get('/client/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('client.tasks.create');
    Route::post('/client/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('client.tasks.store');
    Route::get('/client/tasks/{task}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('client.tasks.edit');
    Route::put('/client/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('client.tasks.update');
    Route::delete('/client/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('client.tasks.destroy');
    Route::patch('/client/tasks/{task}/complete', [App\Http\Controllers\TaskController::class, 'complete'])->name('client.tasks.complete');
    Route::patch('/client/tasks/{task}/pending', [App\Http\Controllers\TaskController::class, 'pending'])->name('client.tasks.pending');
});


// favorite

Route::middleware(['auth', 'role:client'])->group(function () {
    // Routes pour les favoris
    Route::get('/client/favorites', [FavoriteController::class, 'index'])->name('client.favorites');
    Route::post('/client/favorites/{service}', [FavoriteController::class, 'store'])->name('client.favorites.store');
    Route::delete('/client/favorites/{service}', [FavoriteController::class, 'destroy'])->name('client.favorites.destroy');
});

// reviews

Route::middleware(['auth'])->group(function () {

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});





Route::middleware(['auth', 'role:prestataire'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('prestataire.dashboard');
});



// Routes pour le budget
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/budget', [App\Http\Controllers\BudgetController::class, 'index'])->name('budget');
    Route::post('/budget/update', [App\Http\Controllers\BudgetController::class, 'updateBudget'])->name('budget.update');
});


// Routes pour le profil client
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ClientProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ClientProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [App\Http\Controllers\ClientProfileController::class, 'updateProfilePicture'])->name('profile.picture');
    Route::get('/dashboard', [App\Http\Controllers\ClientProfileController::class, 'dashboard'])->name('dashboard');
});
