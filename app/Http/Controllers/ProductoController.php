<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function Crear(Request $req) {
        $producto = new Producto;
        $producto -> peso              = $req -> post("peso");
        $producto -> estado            = $req -> post("estado");
        $producto -> almacen_id        = $req -> post("almacen_id");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");
        $producto -> save();

        return $producto;
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
            if ($req -> has("lote_id"))           $producto -> lote_id           = $req -> post("lote_id");
            if ($req -> has("almacen_id"))        $producto -> almacen_id        = $req -> post("almacen_id");
            if ($req -> has("fecha_entrega"))     $producto -> fecha_entrega     = $req -> post("fecha_entrega");
            if ($req -> has("direccion_entrega")) $producto -> direccion_entrega = $req -> post("direccion_entrega");
            
            
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