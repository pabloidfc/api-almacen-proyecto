<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

class LoteController extends Controller
{
    public function Listar(Request $req) {
        return Lote::all();
    }

    public function ListarUno(Request $req, $idLote) {
        return Lote::findOrFail($idLote);
    }

    public function Modificar(Request $req, $idLote) { // TODO Lote tiene que tener estado
        $lote = Lote::find($idLote); // TODO que pasa si no se encuentra el Lote
        $lote -> estado = $req -> post("estado");
        $lote -> save();
        
        return $lote;
    }

    // TODO Eliminar Lote si el estado es entregado
    public function Eliminar(Request $req, $idLote) {
        $lote = Lote::find($idLote);
        $lote -> delete();

        return ["msg" => "El Lote ha sido eliminado correctamente!"];
    }
}