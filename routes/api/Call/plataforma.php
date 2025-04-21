<?php
use Illuminate\Support\Facades\Route;

Route::resource('plataforma', 'PlataformaController')
    ->only(['index', 'store', 'show', 'update', 'destroy']);
