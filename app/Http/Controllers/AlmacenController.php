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

    public function ListarAlmacenProductos(Request $req, $idAlmacen) {
        $almacen = Almacen::find($idAlmacen);
        
        if ($almacen) {
            $almacen -> Productos;
            return $almacen;
        }

        return response(["msg" => "Almacen no encontrado!"], 404);
    }
}
