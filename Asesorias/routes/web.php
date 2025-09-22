<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;

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
