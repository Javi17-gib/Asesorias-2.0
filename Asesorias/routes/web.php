<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/index", function(){
    return view('index');
});

Route::get("/Inicio", function(){
    return view('Inicio');
});

Route::get("/Login", function(){
    return view('Login');
});

use App\Http\Controllers\MateriaController;

Route::get('/', [MateriaController::class, 'index']);
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');