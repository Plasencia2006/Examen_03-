<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CalzadoController;

Route::get('/', function () {
    return redirect()->route('calzados.index');
});
Route::resource('marcas', MarcaController::class);
Route::resource('calzados', CalzadoController::class);

