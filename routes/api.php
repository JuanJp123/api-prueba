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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/verificar-formulario-registro', [App\Http\Controllers\registroController::class, 'verificar']);
Route::post('/auth/iniciar-sesion/email', [App\Http\Controllers\registroController::class, 'iniciarSesionconEmail']);
Route::post('/registar-usuario', [App\Http\Controllers\registroController::class, 'registrarUsuario']);
