<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller
{
    public function Listar(Request $req) {
        return Almacen::all();
    }

    public function ListarUno(Request $req, $idAlmacen) {
        return Almacen::findOrFail($idAlmacen);
    }
    
    public function ListarUnoUbicacion(Request $req, $idAlmacen) {
        $almacen = Almacen::findOrFail($idAlmacen);

        $almacen -> Ubicacion;
        return $almacen;
    }

    public function ListarAlmacenProductos(Request $req, $idAlmacen) {
        $almacen = Almacen::findOrFail($idAlmacen);
        $almacen -> Productos;

        return $almacen;
    }

    public function ListarPorTipo(Request $req, $tipoAlmacen) {
        $opciones = [
            "Propio"    => "Propio",
            "De terceros"  => "De terceros"
        ];

        if (isset($opciones[$tipoAlmacen])) {
            $almacen = Almacen::where("tipo", "=", $tipoAlmacen) -> get();
            return $almacen;
        }

        return response(["msg" => "El tipo de Almacen no existe!"], 400);
    }
}
