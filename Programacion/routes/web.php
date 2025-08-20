<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DeviceController; // El nuevo controlador funcional
use App\Http\Controllers\MonitoredPcController; // Lo mantenemos para la vista de detalles
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- RUTAS PÚBLICAS ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/nosotros', [PageController::class, 'about'])->name('about');
Route::get('/contactanos', [PageController::class, 'contact'])->name('contact');


// --- RUTAS PROTEGIDAS ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Esta ruta sigue siendo necesaria para ver los detalles de cada PC
    Route::get('/pcs/{pc}', [MonitoredPcController::class, 'show'])->name('pcs.show');
});


// --- RUTAS SOLO PARA ADMINISTRADORES ---
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    // Flujo completo para registrar un nuevo dispositivo
    Route::get('/register-device', [DeviceController::class, 'register'])->name('devices.register');
    Route::post('/register-device', [DeviceController::class, 'store'])->name('devices.store');
    Route::get('/devices/{pc}/token', [DeviceController::class, 'showToken'])->name('devices.show-token');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/carousel', [CarouselController::class, 'index'])->name('carousel.index');
    Route::get('/carousel/create', [CarouselController::class, 'create'])->name('carousel.create');
    Route::post('/carousel', [CarouselController::class, 'store'])->name('carousel.store');
    Route::get('/carousel/{carouselSlide}/edit', [CarouselController::class, 'edit'])->name('carousel.edit');
    Route::put('/carousel/{carouselSlide}', [CarouselController::class, 'update'])->name('carousel.update');
    Route::delete('/carousel/{carouselSlide}', [CarouselController::class, 'destroy'])->name('carousel.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
