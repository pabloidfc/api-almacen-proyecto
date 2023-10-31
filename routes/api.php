<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TransportistaController;

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

Route::group(["middleware" => ["validarApiToken", "funcionario.tipo:Propio"]], function () {
    Route::controller(ProductoController::class) -> group(function () {
        Route::post("/producto", "Crear");
        Route::get("/producto", "Listar");
        Route::get("/producto/estado", "ListarPorEstado");
        Route::get("/producto/{id}", "ListarUno");
        Route::put("/producto/{id}", "Modificar");
        Route::get("/producto/{id}/lote", "ListarProductoLote");
        Route::get("/producto/{id}/almacen", "ListarProductoAlmacen");
        Route::delete("/producto/{id}", "Eliminar");
    });
    
    Route::controller(LoteController::class) -> group(function () {
        Route::post("/lote", "Crear");
        Route::get("/lote", "Listar");
        Route::get("/lote/estado", "ListarPorEstado");
        Route::get("/lote/{id}", "ListarUno");
        Route::put("/lote/{id}", "Modificar");
        Route::get("/lote/{id}/productos", "ListarLoteProductos");
        Route::get("/lote/{id}/destino", "ListarAlmacenDestino");
        Route::get("/lote/{id}/desarmar", "Desarmar");
        Route::delete("/lote/{id}", "Eliminar");
    });
    
    Route::controller(AlmacenController::class) -> group(function () {
        Route::get("/almacen", "Listar");
        Route::get("/almacen/tipo", "ListarPorTipo");
        Route::get("/almacen/{id}", "ListarUno");
        Route::get("/almacen/{id}/productos", "ListarAlmacenProductos");
    });

    Route::controller(VehiculoController::class) -> group(function () {
        Route::get("/vehiculo", "Listar");
        Route::get("/vehiculo/estado", "ListarPorEstado");
        Route::post("/vehiculo/transportistas", "AsignarTransportistas");
        Route::get("/vehiculo/{id}", "ListarUno");
    });

    Route::controller(TransportistaController::class) -> group(function () {
        Route::get("/transportista", "Listar");
        Route::get("/transportista/{id}", "ListarUno");
    });
});

Route::group(["middleware" => ["validarApiToken", "funcionario.tipo:De terceros"]], function () {
    Route::controller(ProductoController::class) -> group(function () {
        Route::post("/producto", "Crear");
    });
});