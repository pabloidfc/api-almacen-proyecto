<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportista;

class TransportistaController extends Controller
{
    public function Listar() {
        $transportistas = Transportista::with("Usuario")->paginate(12);
        return $transportistas;
    }

    public function ListarUno($idTransportista) {
        $transportista = Transportista::find($idTransportista);
        if (!$transportista) return response(["msg" => "Not found!"], 404);
        $transportista->Vehiculo;
        return $transportista;
    }
}
