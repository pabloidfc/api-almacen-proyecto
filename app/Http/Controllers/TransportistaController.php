<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportista;

class TransportistaController extends Controller
{
    public function Listar() {
        return Transportista::all();
    }

    public function ListarUno($idTransportista) {
        $transportista = Transportista::find($idTransportista);
        if (!$transportista) return response(["msg" => "Not found!"], 400);
        return $transportista;
    }
}
