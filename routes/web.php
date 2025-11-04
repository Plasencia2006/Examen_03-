<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hector', function () {
    return view('hector', ['nombre' => 'Héctor Isai Plasencia Alva']);
});