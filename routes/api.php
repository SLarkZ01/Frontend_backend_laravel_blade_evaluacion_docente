<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\RolController;
use App\Http\Controllers\API\ActaCompromisoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for Usuario CRUD operations
Route::apiResource('usuarios', UsuarioController::class);

// API Routes for Rol CRUD operations
Route::apiResource('roles', RolController::class);

// API Routes for ActaCompromiso CRUD operations
Route::apiResource('actas-compromiso', ActaCompromisoController::class);
Route::put('actas-compromiso/{id}/enviar', [ActaCompromisoController::class, 'enviar']);
