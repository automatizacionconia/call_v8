<?php
use Illuminate\Support\Facades\Route;
Route::resource('agente', 'AgenteController')->only(['index', 'store', 'show', 'update', 'destroy']);
