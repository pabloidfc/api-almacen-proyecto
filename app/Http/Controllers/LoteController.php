<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

class LoteController extends Controller
{
    public function Listar(Request $request) {
        return Lote::all();
    }

    public function ListarUno(Request $request, $idLote) {
        return Lote::findOrFail($idLote);
    }

    public function Modificar(Request $request, $idLote) {
        $lote = Producto::find($idLote);
        $lote -> estado = $request -> post("estado");
        $lote -> save();
        return $lote;
    }
}
