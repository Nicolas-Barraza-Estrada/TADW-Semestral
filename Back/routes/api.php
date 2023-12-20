<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\BodegaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para Artículos
Route::get('articulos', [ArticuloController::class, 'index']);
Route::post('articulos', [ArticuloController::class, 'store']);
Route::get('articulos/{articulo}', [ArticuloController::class, 'show']);
Route::put('articulos/{articulo}', [ArticuloController::class, 'update']);
Route::delete('articulos/{articulo}', [ArticuloController::class, 'destroy']);

// Rutas para Bodegas
Route::post('bodegas', [BodegaController::class, 'store']);
