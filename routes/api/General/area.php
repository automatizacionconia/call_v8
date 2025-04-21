<?php
use Illuminate\Support\Facades\Route;

Route::resource('area','AreaController')->only(['index', 'store', 'show', 'update', 'destroy']);
