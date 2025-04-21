<?php

use Illuminate\Support\Facades\Route;

/**
 * Pide
 */
Route::post('status', 'StatusController@index');
Route::post('reniec/consultar', 'ReniecController@consultar');
Route::post('reniec/consultarV1', 'ReniecController@consultarV1');
Route::post('reniec/consultarV2', 'ReniecController@consultarV2');
Route::post('reniec/consultarV3', 'ReniecController@consultarV3');
Route::post('sunat/consultar', 'SunatController@consultar');
Route::post('sunat/consultarV1', 'SunatController@consultarV1');
Route::post('reniec/consultarV4', 'ReniecController@consultarV4');