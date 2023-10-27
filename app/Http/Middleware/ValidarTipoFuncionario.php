<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Funcionario;

class ValidarTipoFuncionario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $userId = $request->attributes->get("user_id");
        $funcionario = Funcionario::where("user_id", $userId)->first();
    
        if ($funcionario && $funcionario->tipo === $type) {
            return $next($request);
        }
    
        return response(["msg" => "No tienes permiso para acceder a esta ruta."], 403);
    }
}
