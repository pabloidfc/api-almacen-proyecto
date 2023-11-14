<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportista;

class TransportistaController extends Controller
{
    public function Listar() {
        $transportista = Transportista::paginate(12);
        return $transportista;
    }

    public function ListarUno($idTransportista) {
        $transportista = Transportista::find($idTransportista);
        if (!$transportista) return response(["msg" => "Not found!"], 404);
        $transportista->Vehiculo;
        return $transportista;
    }
}
