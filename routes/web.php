<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

// Ruta raíz → redirige al listado
Route::get('/', fn() => redirect()->route('vehiculos.index'));

// CRUD completo protegido con autenticación
Route::middleware(['auth'])->group(function () {
    Route::resource('vehiculos', VehiculoController::class);
});

// Rutas de autenticación (generadas por Breeze)
require __DIR__.'/auth.php';
