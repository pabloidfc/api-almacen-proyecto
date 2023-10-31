<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class LoteController extends Controller
{
    public function Crear(Request $req) {
        $creadorId = $req->attributes->get("user_id");

        $validacion = Validator::make($req->all(), [
            "almacen_destino" => "required|integer|exists:almacen,id",
            "idsProductos"    => "required|array", 
            "idsProductos.*"  => "exists:producto,id"
        ]);

        if($validacion->fails()) return response($validacion->errors(), 400);

        $lote = new Lote;
        $lote->peso = 0;
        $lote->Creador()->associate($creadorId);
        $lote->Almacen()->associate($req->input("almacen_destino"));

        $idsProductos = $req->input("idsProductos", []);
        $productos = Producto::whereIn("id", $idsProductos)->get();
        $lote->peso = $productos->sum("peso");
        $lote->save();
        $lote->Productos()->saveMany($productos);

        $lote->Productos;
        return $lote;
    }

    public function Listar() {
        return Lote::all();
    }

    public function ListarUno($idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);
        $lote -> Productos;
        $lote -> Almacen;
        return $lote;
    }

    public function ListarPorEstado(Request $req) {
        $estadoLote = $req->input("estado");
        $validacion = Validator::make($req->all(), [
            "estado" => "required|in:Creado,En viaje,Desarmado"
        ]);

        if($validacion->fails()) return response($validacion->errors(), 400);

        $lote = Lote::where("estado", "=", $estadoLote)->get();
        return $lote;
    }

    public function ListarLoteProductos($idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);
        $lote -> Productos;
        return $lote;
    }

    public function ListarAlmacenDestino($idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);
        $lote -> Almacen;
        return $lote;
    }

    public function Modificar(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);

        $validacion = Validator::make($req->all(), [
            "almacen_destino" => "nullable|integer|exists:almacen,id",
            "estado"          => "nullable|in:Creado,En viaje,Desarmado"
        ]);

        if($validacion->fails()) return response($validacion->errors(), 400);
                
        if($req->input("estado")) $this->modificarEstado($lote, $req->input("estado"));
        if($req->input("almacen_destino")) $this->modificarAlmacenDestino($lote, $req->input("almacen_destino"));
        $lote->save();
        return $lote;
    }

    private function modificarEstado($lote, $estado) {
        $lote->estado = $estado;
    }

    private function modificarAlmacenDestino($lote, $idAlmacen) {
        $lote->Almacen()->associate($idAlmacen);
    }

    public function Desarmar($idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);

        $lote->Productos()->update(["lote_id" => null]);
        $lote->estado = "Desarmado";
        $lote->save();
        return response(["msg" => "Desarmado!"], 200);
    }

    public function Eliminar($idLote) {
        $lote = Lote::find($idLote);
        if(!$lote) return response(["msg" => "Not found!"], 404);
        $lote->delete();
        return ["msg" => "Eliminado!"];
    }
}