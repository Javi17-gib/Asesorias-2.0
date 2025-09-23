<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ContenidoController;

// Inicio redirige a login
Route::get('/', function () { return redirect()->route('login.form'); });

// Login / Registro
Route::get('/Login', function () { return view('login'); })->name('login.form');
Route::post('/Login', [AuthController::class, 'login'])->name('login');
Route::post('/Register', [AuthController::class, 'register'])->name('register');
Route::get('/Logout', [AuthController::class, 'logout'])->name('logout');

// Inicio
Route::get('/Inicio', [MateriaController::class, 'index'])->name('Inicio');

// Crear materia
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');

// Ver materia específica
Route::get('/materia/{codigo}', [MateriaController::class, 'show'])->name('materia.show');

Route::post('/materia/{materiaId}/unidad', [UnidadController::class, 'store'])->name('unidad.store');
Route::post('/unidad/{unidadId}/subtema', [UnidadController::class, 'storeSubtema'])->name('subtema.store');

Route::get('/materia/{codigo}', [MateriaController::class, 'show'])->name('materia.show');
