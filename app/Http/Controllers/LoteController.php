<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Almacen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoteController extends Controller
{
    public function Crear(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "creador_id"      => ["required", "integer", Rule::exists('users', 'id')],
            "almacen_destino" => ["required", "integer", Rule::exists('almacen', 'id')],
            "estado"          => "nullable|in:Creado,En viaje,Desarmado",
            "idsProductos"    => "required|array", 
            "idsProductos.*"  => "exists:producto,id"
        ]);

        if($validaciones->fails())
            return response($validaciones->errors(), 400);

        $lote = new Lote;
        $idsProductos = $req -> input("idsProductos", []);
        
        $lote -> peso   = 0;
        $lote -> estado = $req -> input("estado");
        
        $lote -> Almacen() -> associate($req -> almacen_destino);
        $lote -> Creador() -> associate($req -> creador_id);
        
        $productos = Producto::whereIn('id', $idsProductos)->get(); 
        $lote -> peso = $productos->sum('peso');
        $lote -> save();
        $lote->Productos()->saveMany($productos);
        return $lote;
    }

    public function Listar(Request $req) {
        return Lote::all();
    }

    public function ListarUno(Request $req, $idLote) {
        return Lote::findOrFail($idLote);
    }

    public function ListarPorEstado(Request $req, $estadoLote) {
        $opciones = [
            "Creado"    => "Creado",
            "En viaje"  => "En viaje",
            "Desarmado" => "Desarmado"
        ];

        if (isset($opciones[$estadoLote])) {
            $lote = Lote::where("estado", "=", $estadoLote) -> get();
            return $lote;
        }

        return response(["msg" => "El estado de lote no existe!"], 400);
    }

    public function ListarLoteProductos(Request $req, $idLote) {
        $lote = Lote::findOrFail($idLote);
        
        if ($lote) {
            $lote -> Productos;
            return $lote;
        }

        return response(["msg" => "Lote no encontrado!"], 404);
    }

    public function ListarAlmacenDestino(Request $req, $idLote) {
        $lote = Lote::findOrFail($idLote);
        
        if ($lote) {
            $lote -> Almacen;
            return $lote;
        }

        return response(["msg" => "Lote no encontrado!"], 404);
    }

    public function Modificar(Request $req, $idLote) {
        $lote = Lote::findOrFail($idLote);

        $validaciones = Validator::make($req->all(), [
            "creador_id"      => ["required", "integer", Rule::exists('users', 'id')],
            "almacen_destino" => ["required", "integer", Rule::exists('almacen', 'id')],
            "estado"          => "nullable|in:Creado,En viaje,Desarmado",
            "idsProductos"    => "required|array", 
            "idsProductos.*"  => "exists:producto,id"
        ]);

        if($validaciones->fails())
            return response($validaciones->errors(), 400);
        
        $idsProductos = $req -> input("idsProductos", []);
    
        $lote -> estado = $req -> input("estado");
        
        $lote -> Almacen() -> associate($req -> almacen_destino);
        $lote -> Creador() -> associate($req -> creador_id);
        
        $productos = Producto::whereIn('id', $idsProductos)->get();
        $lote -> peso += $productos->sum('peso');
        $lote -> save();
        $lote->Productos()->saveMany($productos);
        return $lote;

        return response(["msg" => "Lote no encontrado!"], 404);
    }
    
    public function Desarmar(Request $req, $idLote) {
        $lote = Lote::findOrFail($idLote);
        
        if ($lote) {
            $productos = $lote -> Productos;
            
            foreach ($productos as $producto) {
                $producto -> lote_id = null;
                $producto -> save();
            }
            
            $lote -> estado = "Desarmado";
            $lote -> save();
            
            return ["msg" => "Lote desarmado correctamente!"];
        }
        
        return response(["msg" => "Lote no encontrado!"], 404);
    }

    public function Eliminar(Request $req, $idLote) {
        $lote = Lote::findOrFail($idLote);
            
        $lote -> delete();
        return ["msg" => "El Lote ha sido eliminado correctamente!"];

    }
}