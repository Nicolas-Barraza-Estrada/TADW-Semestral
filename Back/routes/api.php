<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ArticuloEnBodegaController;

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
Route::get('articulos', [ArticuloController::class, 'index']); //ok
Route::post('articulos', [ArticuloController::class, 'store']); //ok
Route::put('articulos/{id}/{nombreArticulo}', [ArticuloController::class, 'update']); //ok
Route::delete('articulos/{nombreArticulo}', [ArticuloController::class, 'destroyByNombre']); //ok

// Rutas para Bodegas
Route::post('bodegas', [BodegaController::class, 'store']); //ok
Route::get('bodegas', [BodegaController::class, 'index']); //ok
Route::put('bodegas/{id}/{  }', [BodegaController::class, 'update']);//ok
Route::delete('bodegas/{id}', [BodegaController::class, 'destroy']);//ok

Route::get('ArticulosEnBodega', [ArticuloEnBodegaController::class, 'index']);//ok
Route::get('ArticulosEnBodega/{bodega_id}', [ArticuloEnBodegaController::class, 'show']);//ok
Route::get('ArticulosEnBodega/getCantidadArticulo/{bodega_id}/{articulo_id}', [ArticuloEnBodegaController::class, 'getCantidadArticulo']);//ok
Route::put('ArticulosEnBodega/descontarCantidadArticulo/{bodega_id}/{articulo_id}/{cantidadArticulo}', [ArticuloEnBodegaController::class, 'descontarCantidadArticulo']);//ok

Route::put('ArticulosEnBodega/add10', [ArticuloEnBodegaController::class, 'add10']);//ok

Route::delete('ArticulosEnBodega/destroyByArticuloId/{articulo_id}', [ArticuloEnBodegaController::class, 'destroyByArticuloId']);//ok
Route::put('ArticulosEnBodega/traspaso/{bodega_idOrigen}/{bodega_idDestino}/{articulo_id}/{cantidadArticulo}', [ArticuloEnBodegaController::class, 'traspaso']);//ok