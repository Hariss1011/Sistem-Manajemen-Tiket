<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\OrderController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\HistoriesController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Admin\TipeTiketController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Detail acara
Route::get('/events/{event}', [UserEventController::class, 'show'])
    ->name('events.show');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard: arahkan pengguna sesuai perannya
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    })->name('dashboard');


    // Manajemen pesanan pengguna
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');


    // Manajemen profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        // Manajemen kategori acara
        Route::resource('categories', CategoryController::class);


        // Manajemen tipe tiket
        Route::resource('tipe_tiket', TipeTiketController::class);


        // Manajemen acara
        Route::resource('events', AdminEventController::class);


        // Manajemen lokasi
        Route::resource('lokasis', LokasiController::class);


        // Manajemen tiket
        Route::resource('tickets', TiketController::class);


        // Riwayat aktivitas
        Route::get('/histories', [HistoriesController::class, 'index'])
            ->name('histories.index');

        Route::get('/histories/{id}', [HistoriesController::class, 'show'])
            ->name('histories.show');
    });


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
