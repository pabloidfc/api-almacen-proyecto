<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    public function Listar() {
        return Vehiculo::all();
    }

    public function ListarUno($idVehiculo) {
        $vehiculo = Vehiculo::find($idVehiculo);
        if(!$vehiculo) return response(["msg" => "Not found!"], 400);
        return $vehiculo;
    }

    public function ListarPorEstado(Request $req) {
        $validacion = Validator::make($req->all(), [
            "estado" => "required|in:Disponible,No disponible,En reparación"
        ]);

        if ($validacion->fails()) return response(["msg" => $validacion->errors()], 400);

        $vehiculo = Vehiculo::where("estado", $req->input("estado"))->get();
        return $vehiculo;
    }
}
