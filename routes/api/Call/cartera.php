<?php

use App\Http\Controllers\Api\Call\CarteraController;
use Illuminate\Support\Facades\Route;

Route::get('cartera/clientes', [CarteraController::class, 'clientes']);
Route::get('cartera/agentes', [CarteraController::class, 'agentes']);
Route::post('cartera/store', [CarteraController::class, 'store']);
Route::get('cartera/asignados', [CarteraController::class, 'carteraGrupo']);
Route::get('cartera/llamadas-telefono/{id}', [CarteraController::class, 'llamadasTelefono']);
Route::get('cartera/dashboard', [CarteraController::class, 'dashboard']);
Route::get('cartera/export-excel', [CarteraController::class, 'exportExcel']);