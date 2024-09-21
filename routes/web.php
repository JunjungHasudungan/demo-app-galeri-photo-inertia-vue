<?php

use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController
};

use App\Http\Controllers\User\{
    DashboardController as UserDashboardController
};
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // ROUTE FOR ADMIN
    Route::get('/galeri-photo', [PostController::class, 'index'])->name('galeri-photo.index');
    Route::get('admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');

    // ROUTE FOR USER
    Route::get('user-dashboard', [UserDashboardController::class, 'index'])->name('user-dashboard');

    // ROUTE FOR ALL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
