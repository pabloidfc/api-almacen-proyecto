<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function Listar(Request $req) {
        return Producto::all();
    }

    public function ListarUno(Request $req, $idProducto) {
        return Producto::find($idProducto);
    }

    public function Crear(Request $req) {
        $producto = new Producto;
        $producto -> peso            = $req -> post("peso");
        $producto -> estado          = $req -> post("estado");
        $producto -> fecha_entrega   = $req -> post("fecha_entrega");
        $producto -> almacen_destino = $req -> post("almacen_destino");
        $producto -> save();

        return $producto;
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        $producto -> estado = $req -> post("estado");
        $producto -> save();
        return $producto;
    }

    public function Eliminar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        $producto -> delete();

        return ["msg" => "El Producto ha sido eliminado correctamente!"];
    }
}
