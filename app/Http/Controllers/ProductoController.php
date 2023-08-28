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
        return Producto::findOrFail($idProducto);
    }

    public function Crear(Request $req) {
        $producto = new Producto;
        $producto -> peso              = $req -> post("peso");
        $producto -> almacen_id        = $req -> post("almacen_id");
        $producto -> estado            = $req -> post("estado");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");
        $producto -> save();

        return $producto;
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        $producto -> estado = $req -> post("estado");
        $producto -> save();
        return $producto;
    }

    // TODO Eliminar Producto si el estado es entregado
    public function Eliminar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        $producto -> delete();

        return ["msg" => "El Producto ha sido eliminado correctamente!"];
    }
}