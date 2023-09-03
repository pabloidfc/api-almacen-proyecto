<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoteController;

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
    Route::get("/producto", "Listar");
    Route::get("/producto/{id}", "ListarUno");
    Route::post("/producto", "Crear");
    Route::put("/producto/{id}", "Modificar");
    Route::delete("/producto/{id}", "Eliminar");
});

Route::controller(LoteController::class) -> group(function () {
    Route::get("/lote", "Listar");
    Route::get("/lote/{id}", "ListarUno");
    Route::put("/lote/{id}", "Modificar");
    Route::post("/lote", "Crear");
    Route::delete("/lote/{id}", "Eliminar");
    Route::put("/lote/desarmar/{id}", "Desarmar");
    Route::get("/lote/productos/{id}", "ListarLoteProductos");
});