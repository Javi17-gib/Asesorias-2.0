<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\SubtemaController;
use App\Http\Controllers\DescripcionMateriaController;
use App\Http\Controllers\ImagenMateriaController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\PerfilController;


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

Route::get('/subtema/{subtema}', [SubtemaController::class, 'show'])->name('subtemas.show');

// Guardar descripción de subtema
Route::post('/subtema/descripcion', [SubtemaController::class, 'guardarDescripcion'])
     ->name('subtemas.descripcion.store');

Route::post('/materia/{materia}/unidad', [UnidadController::class, 'store'])
     ->name('unidad.store');

Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])->name('chatbot.message');
Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage']);

Route::put('/unidad/{id}', [UnidadController::class, 'update'])->name('unidad.update');
Route::delete('/unidad/{unidad}', [UnidadController::class, 'destroy'])->name('unidad.destroy');
Route::delete('/subtemas/{subtema}', [SubtemaController::class, 'destroy'])->name('subtemas.destroy');
Route::put('/subtemas/{subtema}', [SubtemaController::class,'update'])->name('subtemas.update');



Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
Route::post('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');


