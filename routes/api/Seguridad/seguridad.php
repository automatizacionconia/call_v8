<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Seguridad\SeguridadController;
use App\Http\Controllers\Api\Seguridad\UsuariosController;
use App\Http\Controllers\Api\Seguridad\PerfilController;
use App\Http\Controllers\Api\Seguridad\OpcionesController;

Route::post('login', [SeguridadController::class, 'login']);
Route::post('logout', [SeguridadController::class, 'logout']);
Route::post('reset-password', [SeguridadController::class, 'resetPassword'])->name('resetPassword');
Route::post('change-password', [SeguridadController::class, 'changePassword'])->name('changePassword');

Route::get('usuarios', [UsuariosController::class, 'index']);
Route::get('usuarios/{id}', [UsuariosController::class, 'show']);
Route::post('usuarios', [UsuariosController::class, 'store']);
Route::put('usuarios/{id}', [UsuariosController::class, 'update']);
Route::put('usuarios/{id}/activar', [UsuariosController::class, 'activar']);
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy']);
Route::get('usuarios/accesos/{id}', [UsuariosController::class, 'accesosUsuario']);
Route::put('usuarios/grabar-acceso-usuario/{id}', [UsuariosController::class, 'grabarAccesoUsuario']);

#Route::get('perfil', [PerfilController::class, 'index']);
Route::get('perfil/accesos/{id}', [PerfilController::class, 'accesosPerfil'])->name('accesosPerfil');
Route::post('perfil/accesos/store', [PerfilController::class, 'storePerfil'])->name('storePerfil');

Route::resource('perfil','PerfilController')->only(['index', 'store', 'show', 'update', 'destroy']);
Route::resource('persona','PersonaController')->only(['index', 'store', 'show', 'update', 'destroy']);

#accesos
Route::resource('accesos','AccesosController')->only(['index', 'store', 'show', 'update', 'destroy']);

#Options
Route::get('opciones/allOpciones', [OpcionesController::class, 'allOpciones'])->name('opciones.allOpciones');
Route::get('opciones/getmenus', [OpcionesController::class, 'getmenus'])->name('opciones.getmenus');
Route::resource('opciones','OpcionesController')->only(['index', 'store', 'show', 'update', 'destroy']);

Route::resource('empresa','EmpresasController')->only(['index', 'store', 'show', 'update', 'destroy']);
Route::resource('pais','PaisController')->only(['index', 'store', 'show', 'update', 'destroy']);