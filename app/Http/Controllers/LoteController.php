<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;

class LoteController extends Controller
{
    public function Listar(Request $req) {
        return Lote::all();
    }

    public function ListarUno(Request $req, $idLote) {
        return Lote::findOrFail($idLote);
    }

    public function Modificar(Request $req, $idLote) {
        $lote = Lote::find($idLote);

        if ($req -> has("peso"))            $lote -> peso            = $req -> post("peso");
        if ($req -> has("estado"))          $lote -> estado          = $req -> post("estado");
        if ($req -> has("almacen_destino")) $lote -> almacen_destino = $req -> post("almacen_destino");

        $lote -> save();
        
        return $lote;
    }

    public function Eliminar(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        $lote -> delete();

        return ["msg" => "El Lote ha sido eliminado correctamente!"];
    }

    public function Crear(Request $req) {
        $lote = new Lote;
        $idsProductos = $req -> post("productos");

        $lote -> peso            = $req -> post("peso");
        $lote -> estado          = $req -> post("estado");
        $lote -> almacen_destino = $req -> post("almacen_destino");
        $lote -> save();

        foreach ($idsProductos as $idPorducto) {
            $producto = Producto::find($idPorducto);
            if ($producto) {
                $lote -> Productos() -> save($producto);
            }
        }

        return $lote;
    }
}