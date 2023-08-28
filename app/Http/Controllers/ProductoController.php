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

    public function Crear(Request $req) { // TODO: comprobar si existe el almacen_id
        $producto = new Producto;
        $producto -> peso              = $req -> post("peso");
        $producto -> estado            = $req -> post("estado");
        $producto -> almacen_id        = $req -> post("almacen_id");
        $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        $producto -> direccion_entrega = $req -> post("direccion_entrega");
        $producto -> save();

        return $producto;
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);

        if ($req -> has("peso"))              $producto -> peso              = $req -> post("peso");
        if ($req -> has("estado"))            $producto -> estado            = $req -> post("estado");
        if ($req -> has("almacen_id"))        $producto -> almacen_id        = $req -> post("almacen_id");
        if ($req -> has("fecha_entrega"))     $producto -> fecha_entrega     = $req -> post("fecha_entrega");
        if ($req -> has("direccion_entrega")) $producto -> direccion_entrega = $req -> post("direccion_entrega");
        
        
        $producto -> save();
        return $producto;
    }

    public function Eliminar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        $producto -> delete();

        return ["msg" => "El Producto ha sido eliminado correctamente!"];
    }
}