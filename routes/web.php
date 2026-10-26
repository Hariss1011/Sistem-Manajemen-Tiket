<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Admin\HistoriesController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\Admin\TipeTiketController;
use App\Http\Controllers\Admin\LokasiController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Event routes
Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    // Tujuan redirect bawaan Breeze (register, verifikasi email, konfirmasi password)
    Route::get('/dashboard', fn() => auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home'))->name('dashboard');

    // Order Routes (wajib login)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//routes admin
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Tipe Tiket Management
    Route::resource('tipe_tiket', TipeTiketController::class);

    // Event Management
    Route::resource('events', AdminEventController::class);

    //Lokasi Management
    Route::resource('lokasis', LokasiController::class);

    // Tiket Management 
    Route::resource('tickets', TiketController::class);

    // Histories
    Route::get('/histories', [HistoriesController::class, 'index'])->name('histories.index');
    Route::get('/histories/{id}', [HistoriesController::class, 'show'])->name('histories.show');
});


require __DIR__ . '/auth.php';
