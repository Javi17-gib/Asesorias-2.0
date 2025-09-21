<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () { return view('welcome'); });
Route::get('/index', function () { return view('index'); });


Route::get('/Login', function () {
    return view('login');
})->name('login.form');

Route::post('/Login', [AuthController::class, 'login'])->name('login');
Route::post('/Register', [AuthController::class, 'register'])->name('register');
Route::get('/Logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/Inicio', function () {
    if (!session()->has('usuario_id')) {
        return redirect()->route('login.form');
    }
    return view('Inicio');
})->name('Inicio');

