<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruta;

class RutaController extends Controller
{
    public function Listar() {
        return Ruta::all();
    }    

    public function ListarUno($idRuta) {
        $ruta = Ruta::find($idRuta);
        if(!$ruta) return response(["msg" => "Not found!"], 404);
        return $ruta;
    }
}
