<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Almacen;

class LoteController extends Controller
{
    public function Crear(Request $req) {
        $lote = new Lote;
        $idsProductos = $req -> post("productos");
        
        $lote -> peso            = $req -> post("peso");
        $lote -> estado          = $req -> post("estado");
        $lote -> save();
        
        if ($req -> has("almacen_destino")) {
            $almacen = Almacen::find($req -> post("almacen_destino"));
            if ($almacen) $lote -> Almacen() -> save($almacen);
        };
        

        if ($idsProductos) {
            foreach ($idsProductos as $idPorducto) {
                $producto = Producto::find($idPorducto);
                if ($producto) $lote -> Productos() -> save($producto);
            }
        }
        
        return $lote;
    }

    public function Listar(Request $req) {
        return Lote::all();
    }

    public function ListarUno(Request $req, $idLote) {
        return Lote::findOrFail($idLote);
    }

    public function ListarLoteProductos(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        
        if ($lote) {
            $lote -> Productos;
            return $lote;
        }

        return response(["msg" => "Lote no encontrado!"], 404);
    }

    public function Modificar(Request $req, $idLote) {
        $lote = Lote::find($idLote);

        if ($lote) {
            if ($req -> has("peso"))            $lote -> peso            = $req -> post("peso");
            if ($req -> has("estado"))          $lote -> estado          = $req -> post("estado");
            if ($req -> has("almacen_destino")) $lote -> almacen_destino = $req -> post("almacen_destino");
    
            $lote -> save();
            return $lote;
        }
        
        return response(["msg" => "Lote no encontrado!"], 404);
    }
    
    public function Desarmar(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        
        if ($lote) {
            $productos = $lote -> Productos;
            
            if ($productos) {
                foreach ($productos as $producto) {
                    $producto -> lote_id = null;
                    $producto -> save();
                }
            }
            
            $lote -> estado = "Desarmado";
            $lote -> save();
            
            return ["msg" => "Lote desarmado correctamente!"];
        }
        
        return response(["msg" => "Lote no encontrado!"], 404);
    }

    public function Eliminar(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        
        if ($lote) {
            if ($lote -> Productos() -> count() > 0) {
                return response(["msg" => "El Lote no se ha podido eliminar!"], 400);
            };
            
            $lote -> delete();
            return ["msg" => "El Lote ha sido eliminado correctamente!"];
        }

        return response(["msg" => "Lote no encontrado!"], 404);
    }
}