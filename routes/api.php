<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([

    'middleware' => 'api',
   

], function ($router) {

   // Route::post('login', ['as' => 'login', 'uses' =>[App\Http\Controllers\loginController::class, 'iniciarSesionConEmail']]);
   Route::get('/fincasUsuario/', [App\Http\Controllers\loginController::class, 'index']);
    
   // Route::post('/iniciar-sesion/email', [App\Http\Controllers\loginController::class, 'iniciarSesionConEmail'])->name('login');

});

Route::post('v1/verificar-formulario-registro', [App\Http\Controllers\registroController::class, 'verificar']);
Route::post('v1/auth/iniciar-sesion/email', [App\Http\Controllers\loginController::class, 'iniciarSesionconEmail'])->name('login');
Route::post('v1/registar-usuario', [App\Http\Controllers\registroController::class, 'registrarUsuario']);
Route::post('v1/me', [App\Http\Controllers\loginController::class, 'me']);
Route::get('v1/razas/traer', [App\Http\Controllers\loteController::class, 'razas']);
Route::get('v1/productos/traer', [App\Http\Controllers\loteController::class, 'productos']);
Route::post('v1/lotes/crear', [App\Http\Controllers\loteController::class, 'crear']);
Route::post('v1/video/subir', [App\Http\Controllers\loteController::class, 'subirVideo']);


