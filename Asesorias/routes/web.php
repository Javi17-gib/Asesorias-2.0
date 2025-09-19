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
