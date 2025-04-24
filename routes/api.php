<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Acta de Compromiso API Routes
Route::prefix('actas-compromiso')->group(function () {
    Route::get('/', [ActaCompromisoController::class, 'index']);
    Route::get('/{id}', [ActaCompromisoController::class, 'show']);
    Route::post('/', [ActaCompromisoController::class, 'store']);
    Route::put('/{id}', [ActaCompromisoController::class, 'update']);
    Route::delete('/{id}', [ActaCompromisoController::class, 'destroy']);
});

