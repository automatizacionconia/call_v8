<?php

use App\Http\Controllers\Api\Call\ClienteController;
use Illuminate\Support\Facades\Route;

Route::post('cliente/cargar-masiva', [ClienteController::class, 'cargarMasiva']);
Route::get('cliente/download-template', [ClienteController::class, 'downloadTemplate']);
Route::resource('cliente','ClienteController')->only(['index', 'store', 'show', 'update', 'destroy']);