<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\SubtemaController;
use App\Http\Controllers\DescripcionMateriaController;
use App\Http\Controllers\ImagenMateriaController;

// Inicio redirige a login
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Login / Registro
Route::get('/Login', function () {
    return view('login');
})->name('login.form');

Route::post('/Login', [AuthController::class, 'login'])->name('login');
Route::post('/Register', [AuthController::class, 'register'])->name('register');
Route::get('/Logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard / Inicio
Route::get('/Inicio', [MateriaController::class, 'index'])->name('Inicio');

// Materias
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
Route::get('/materia/{codigo}', [MateriaController::class, 'show'])->name('materia.show');

// Unidades
Route::post('/materia/{materia}/unidad', [UnidadController::class, 'store'])->name('unidad.store');

// Subtemas
Route::post('/subtemas', [SubtemaController::class, 'store'])->name('subtemas.store');

// Descripción de materias
Route::post('/descripcion-materia', [DescripcionMateriaController::class, 'store'])->name('descripcion.store');
Route::get('/descripcion-materia/{materia}', [DescripcionMateriaController::class, 'show'])->name('descripcion.show');

// Imágenes de materia
Route::post('/materia/imagen', [ImagenMateriaController::class, 'store'])->name('imagen.store');
Route::get('/materia/imagenes/{materia}', [ImagenMateriaController::class, 'index'])->name('imagen.index');

Route::post('/imagen/store', [ImagenMateriaController::class, 'store'])->name('imagen.store');

Route::post('/imagen/store', [ImagenMateriaController::class, 'store'])
     ->name('imagen.store')
     ->middleware('web'); // importante, para que funcione la sesión