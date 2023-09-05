<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AlmacenController;

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

Route::middleware('auth:sanctum') -> get('/user', function (Request $request) {
    return $request -> user();
});

Route::controller(ProductoController::class) -> group(function () {
    Route::post("/producto", "Crear");
    Route::get("/producto", "Listar");
    Route::get("/producto/{id}", "ListarUno");
    Route::get("/producto/estado/{estado}", "ListarPorEstado");
    Route::get("/producto/lote/{id}", "ListarProductoLote");
    Route::get("/producto/almacen/{id}", "ListarProductoAlmacen");
    Route::put("/producto/{id}", "Modificar");
    Route::delete("/producto/{id}", "Eliminar");
});

Route::controller(LoteController::class) -> group(function () {
    Route::post("/lote", "Crear");
    Route::get("/lote", "Listar");
    Route::get("/lote/{id}", "ListarUno");
    Route::get("/lote/estado/{estado}", "ListarPorEstado");
    Route::get("/lote/productos/{id}", "ListarLoteProductos");
    Route::get("/lote/destino/{id}", "ListarAlmacenDestino");
    Route::put("/lote/{id}", "Modificar");
    Route::put("/lote/desarmar/{id}", "Desarmar");
    Route::delete("/lote/{id}", "Eliminar");
});

Route::controller(AlmacenController::class) -> group(function () {
    Route::get("/almacen", "Listar");
    Route::get("/almacen/{id}", "ListarUno");
    Route::get("/almacen/ubicacion/{id}", "ListarUnoUbicacion");
    Route::get("/almacen/tipo/{tipo}", "ListarPorTipo");
    Route::get("/almacen/productos/{id}", "ListarAlmacenProductos");
});