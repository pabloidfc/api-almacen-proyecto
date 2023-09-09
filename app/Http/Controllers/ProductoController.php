<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Lote;

class ProductoController extends Controller
{
    public function Crear(Request $req) {
        $producto = new Producto;
        $producto -> peso              = $req -> post("peso");
        $producto -> estado            = $req -> post("estado");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");  

        $almacen = $this -> existeAlmacen($req -> post("almacen_id"));
        if ($almacen)  {
            $producto -> Almacen() -> associate($almacen);
        } else {
            return response(["msg" => "El Almacen no existe!"], 400);
        }

        $producto -> save();
        return $producto;
    }

    private function existeAlmacen($idAlmacen) {
        $almacen = Almacen::find($idAlmacen);
        return $almacen ? $almacen : false;
    }

    private function existeLote($idLote) {
        $lote = Lote::find($idLote);
        return $lote ? $lote : false;
    }

    public function Listar(Request $req) {
        return Producto::all();
    }

    public function ListarUno(Request $req, $idProducto) {
        return Producto::findOrFail($idProducto);
    }

    public function ListarPorEstado(Request $req, $estadoProducto) {
        $opciones = [
            "En espera"  => "En espera",
            "Almacenado" => "Almacenado",
            "Loteado"    => "Loteado",
            "Desloteado" => "Desloteado", 
            "En viaje"   => "En viaje", 
            "Entregado"  => "Entregado"
        ];

        if (isset($opciones[$estadoProducto])) {
            $producto = Producto::where("estado", "=", $estadoProducto) -> get();
            return $producto;
        }

        return response(["msg" => "El estado de Producto no existe!"], 400);
    }

    public function ListarProductoLote(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);

        if ($producto) {
            $producto -> Lote;
            return $producto;
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }

    public function ListarProductoAlmacen(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);

        if ($producto) {
            $producto -> Almacen;
            return $producto;
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);

        if ($producto) {
            if ($req -> has("peso"))              $producto -> peso              = $req -> post("peso");
            if ($req -> has("estado"))            $producto -> estado            = $req -> post("estado");
            if ($req -> has("fecha_entrega"))     $producto -> fecha_entrega     = $req -> post("fecha_entrega");
            if ($req -> has("direccion_entrega")) $producto -> direccion_entrega = $req -> post("direccion_entrega");
            
            if ($req -> has("almacen_id")) {
                $almacen = $this -> existeAlmacen($req -> post("almacen_id"));
                if ($almacen) {
                    $producto -> Almacen() -> associate($almacen);
                } else {
                    return response(["msg" => "El Almacen no existe!"], 400);
                }
            }

            if ($req -> has("lote_id")) {
                $lote = $this -> existeLote($req -> post("lote_id"));
                if ($lote) {
                    $producto -> Lote() -> associate($lote);
                } else {
                    return response(["msg" => "El Lote no existe!"], 400);
                }
            }
            
            $producto -> save();
            return $producto;
        }
        
        return response(["msg" => "Producto no encontrado!"], 404);
    }
    
    public function Eliminar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        
        if ($producto) {
            $producto -> delete();
            
            return ["msg" => "El Producto ha sido eliminado correctamente!"];
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }
}