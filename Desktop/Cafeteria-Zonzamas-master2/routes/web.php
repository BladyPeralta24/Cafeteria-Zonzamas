<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GestionReservaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de presentación (pública)
Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    // Carta (la ruta se llama "dashboard" porque Breeze redirige ahí tras el login)
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito ("Mi reserva")
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/confirmar', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Reservas del cliente
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::patch('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

    // Panel del personal (admin / empleado)
    Route::get('/gestion/reservas', [GestionReservaController::class, 'index'])->name('gestion.reservas');
    Route::patch('/gestion/reservas/{reserva}', [GestionReservaController::class, 'update'])->name('gestion.reservas.update');
});

require __DIR__.'/auth.php';
