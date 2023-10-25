<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use Illuminate\Support\Facades\Validator;

class AlmacenController extends Controller
{
    public function Listar() {
        return Almacen::all();
    }

    public function ListarUno($idAlmacen) {
        $almacen = Almacen::find($idAlmacen);
        if (!$almacen) return response(["msg" => "Not found!"], 404);
        $almacen -> Ubicacion;
        return $almacen;
    }

    public function ListarAlmacenProductos($idAlmacen) {
        $almacen = Almacen::find($idAlmacen);
        if (!$almacen) return response(["msg" => "Not found!"], 404);
        $almacen -> Ubicacion;
        $almacen -> Productos;
        return $almacen;
    }

    public function ListarPorTipo(Request $req) {
        $tipoAlmacen = $req->input("tipo");
        $validacion = Validator::make($req->all(), [
            "tipo" => "required|in:Propio,De terceros"
        ]);

        if ($validacion->fails()) return response(["msg" => $validacion->errors()], 400);

        $almacen = Almacen::where("tipo", "=", $tipoAlmacen) -> get();
        return $almacen;
    }
}
