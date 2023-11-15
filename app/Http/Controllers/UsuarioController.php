<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function ListarUsuario(Request $req) {
        $user_id = $req->attributes->get("user_id");
        $usuario = User::find($user_id);
        $usuario->Ubicacion;
        $usuario->Telefono;
        return $usuario;
    }

    public function Listar() {
        return User::all();
    }

    public function ListarUno($idUsuario) {
        $usuario = User::find($idUsuario);
        if(!$usuario) return response(["msg" => "Not found!"], 404);
        return $usuario;
    }
}
