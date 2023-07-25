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

    public function Modificar(Request $req, $idLote) {
        $lote = Producto::find($idLote);
        $lote -> estado = $req -> post("estado");
        $lote -> save();
        return $lote;
    }
}
