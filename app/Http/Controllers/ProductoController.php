<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Lote;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function Crear(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "almacen_id"        => ["required", "integer", Rule::exists('almacen', 'id')],
            "estado"            => "nullable|in:En espera, Almacenado, Loteado, Desloteado, En viaje, Entregado",
            "peso"              => "required|numeric",
            "departamento"      => "required|alpha|min:4",
            "direccion_entrega" => "required|string",
            "fecha_entrega"     => "required|date"
        ], [
            "almacen_id.exists" => "The provided id do not match any Almacen"
        ]);

        if($validaciones->fails()) 
            return $validaciones->errors();

        $producto = new Producto;
        $producto -> peso              = $req -> post("peso");
        $producto -> estado            = $req -> post("estado");
        $producto -> departamento      = $req -> post("departamento");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");  

        $producto -> Almacen() -> associate($req->almacen_id);

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

        return response(["msg" => "Productos no encontrados!"], 404);
    }

    public function ListarProductoLote(Request $req, $idProducto) {
        $producto = Producto::findOrFail($idProducto);

        if ($producto) {
            $producto -> Lote;
            return $producto;
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }

    public function ListarProductoAlmacen(Request $req, $idProducto) {
        $producto = Producto::findOrFail($idProducto);

        if ($producto) {
            $producto -> Almacen;
            return $producto;
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::findOrFail($idProducto);

        $validaciones = Validator::make($req->all(), [
            "almacen_id"        => ["required", "integer", Rule::exists('almacen', 'id')],
            "estado"            => "nullable|in:En espera, Almacenado, Loteado, Desloteado, En viaje, Entregado",
            "peso"              => "required|numeric",
            "departamento"      => "required|alpha|min:4",
            "direccion_entrega" => "required|string",
            "fecha_entrega"     => "required|date"
        ], [
            "almacen_id.exists" => "The provided id do not match any Almacen"
        ]);

        if($validaciones->fails()) 
            return $validaciones->errors();

        $producto -> peso              = $req -> post("peso");
        $producto -> estado            = $req -> post("estado");
        $producto -> departamento      = $req -> post("departamento");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");  
        
        $producto -> Almacen() -> associate($req->almacen_id);
        $producto -> save();


        return $producto;
    }
    
    public function Eliminar(Request $req, $idProducto) {
        $producto = Producto::findOrFail($idProducto);
        
        if ($producto) {
            $producto -> delete();
            
            return ["msg" => "El Producto ha sido eliminado correctamente!"];
        }

        return response(["msg" => "Producto no encontrado!"], 404);
    }
}