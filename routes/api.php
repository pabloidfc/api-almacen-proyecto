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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/producto", [ProductoController::class, "Listar"]);
Route::get("/producto/{id}", [ProductoController::class, "ListarUno"]);
Route::post("/producto", [ProductoController::class, "Crear"]);
Route::put("/producto/{id}", [ProductoController::class, "Modificar"]);
Route::delete("/producto/{id}", [ProductoController::class, "Eliminar"]);

Route::get("/lote", [LoteController::class, "Listar"]);
Route::get("/lote/{id}", [LoteController::class, "ListarUno"]);
Route::put("/lote/{id}", [LoteController::class, "Modificar"]);