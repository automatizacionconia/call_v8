<?php
use Illuminate\Support\Facades\Route;

Route::resource('grupo', 'GrupoController')->only(['index', 'store', 'show', 'update', 'destroy']);