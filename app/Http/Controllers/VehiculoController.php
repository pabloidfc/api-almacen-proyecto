<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Transportista;
use App\Models\Lote;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    public function Listar() {
        $vehiculos = Vehiculo::paginate(12);
        return $vehiculos;
    }

    public function ListarUno($idVehiculo) {
        $vehiculo = Vehiculo::find($idVehiculo);
        if(!$vehiculo) return response(["msg" => "Not found!"], 404);
        $vehiculo->Transportista;
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

    // public function AsignarTransportistas(Request $req) {
    //     $validacion = Validator::make($req->all(), [
    //         "vehiculo_id"         => "required|integer|exists:vehiculo,id",
    //         "idsTransportistas"   => "required|array", 
    //         "idsTransportistas.*" => "exists:transportista,user_id"
    //     ]);

    //     if($validacion->fails()) return response($validacion->errors(), 400);

    //     $vehiculo = Vehiculo::find($req->input("vehiculo_id"));
    //     if($vehiculo->estado == "En reparación") return response(["msg" => "Vehiculo not available!"]);

    //     $idsTransportistas = $req->input("idsTransportistas", []);
    //     $transportistas = Transportista::whereIn("user_id", $idsTransportistas)->get();
    //     $vehiculo->Transportista()->saveMany($transportistas);

    //     $vehiculo->Transportista;
    //     return $vehiculo;
    // }

    // public function DesasignarTransportistas(Request $req) {
    //     $validacion = Validator::make($req->all(), [
    //         "vehiculo_id" => "required|integer|exists:vehiculo,id"
    //     ]);
    //     if($validacion->fails()) return response($validacion->errors(), 400);
    //     $vehiculo = Vehiculo::find($req->input("vehiculo_id"));
    //     $vehiculo->Transportista()->update(["vehiculo_id" => null]);
    //     return $vehiculo;
    // }

    // public function CrearViaje(Request $req) {
    //     $validacion = Validator::make($req->all(), [
    //         "vehiculo_id" => "required|integer|exists:vehiculo,id",
    //         "idsLotes" => "required|array",
    //         "idsLotes.*" => "exists:lote,id",
    //         "ruta_id" => "required|integer|exists:ruta,id",
    //         "salida_programada" => "required|date_format:Y-m-d H:i:s"
    //     ]);

    //     if($validacion->fails()) return response($validacion->errors(), 400);
        
    //     $vehiculo = Vehiculo::find( $req->input("vehiculo_id") );
    //     $idsLotes = $req->input("idsLotes", []);
    //     $salidaProgramada = $req->input("salida_programada");
    //     $idRuta = $req->input("ruta_id");
        
    //     if( $this->checkPeso($vehiculo, $idsLotes) ) return response(["msg" => "Wrong weight!"], 400);

    //     $this->CrearViajeAsignado($idRuta, $vehiculo, $idsLotes);
    //     $this->CrearVehiculoTransporta($vehiculo, $idsLotes, $salidaProgramada);

    //     $vehiculo->VehiculoTransporta;
    //     return $vehiculo;
    // }

    // private function CrearVehiculoTransporta($vehiculo, $idsLotes, $salidaProgramada) {
    //     $orden = 1;

    //     foreach($idsLotes as $idLote) {
    //         $vehiculo->VehiculoTransporta()->create([
    //             "lote_id" => $idLote,
    //             "orden" => $orden,
    //             "salida_programada" => $salidaProgramada
    //         ]); 
    //         $orden++;
    //     }
    // }

    // private function CrearViajeAsignado($idRuta, $vehiculo, $idsLotes) {
    //     $viaje = new Viaje;
    //     $viaje->Ruta()->associate($idRuta);

    //     foreach($idsLotes as $idLote) {
    //         $viaje->ViajeAsignado()->create([
    //             "vehiculo_id" => $vehiculo->id,
    //             "lote_id" => $idLote,
    //             "viaje_id" => $viaje->id
    //         ]);
    //     }

    //     $viaje->save();
    // }

    // private function checkPeso($vehiculo, $idsLotes) {
    //     $lotes = Lote::whereIn("id", $idsLotes)->get();
    //     $limitePesoVehiculo = $vehiculo->limite_peso;
    //     $pesoLotes = $lotes->sum("peso");

    //     return $pesoLotes > $limitePesoVehiculo;
    // }
}
