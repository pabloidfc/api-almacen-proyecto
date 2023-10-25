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

Route::get("/login", function () {
    return response()->json(["msg" => "Sin permisos"]);
}) -> name("login");

Route::middleware('auth:sanctum') -> get('/user', function (Request $request) {
    return $request -> user();
});

Route::middleware("validarApiToken") -> group(function () {
    Route::controller(ProductoController::class) -> group(function () {
        Route::post("/producto", "Crear");
        Route::get("/producto", "Listar");
        Route::get("/producto/{id}", "ListarUno");
        Route::get("/producto/estado/{estado}", "ListarPorEstado");
        Route::get("/producto/{id}/lote", "ListarProductoLote");
        Route::get("/producto/{id}/almacen", "ListarProductoAlmacen");
        Route::put("/producto/{id}", "Modificar");
        Route::delete("/producto/{id}", "Eliminar");
    });
    
    Route::controller(LoteController::class) -> group(function () {
        Route::post("/lote", "Crear");
        Route::get("/lote", "Listar");
        Route::get("/lote/{id}", "ListarUno");
        Route::get("/lote/estado/{estado}", "ListarPorEstado");
        Route::get("/lote/{id}/productos", "ListarLoteProductos");
        Route::get("/lote/{id}/destino", "ListarAlmacenDestino");
        Route::put("/lote/{id}", "Modificar");
        Route::put("/lote/{id}/desarmar", "Desarmar");
        Route::delete("/lote/{id}", "Eliminar");
    });
    
    Route::controller(AlmacenController::class) -> group(function () {
        Route::get("/almacen", "Listar");
        Route::get("/almacen/tipo", "ListarPorTipo");
        Route::get("/almacen/{id}", "ListarUno");
        Route::get("/almacen/{id}/productos", "ListarAlmacenProductos");
    });
});