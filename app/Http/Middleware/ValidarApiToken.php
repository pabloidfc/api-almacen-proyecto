<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ValidarApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();

            $res = Http::withHeaders([
                "Accept"        => "application/json",
                "Content-Type"  => "application/json",
                "Authorization" => "Bearer " . $token,
            ])->get("http://localhost:8000/api/validate");
    
            if ($res->getStatusCode() != "200") return response(["msg" => __("auth.failed")], 401);

            $usuario = $res->json();
            $request->attributes->add(["user_id" => $usuario["id"]]);
            return $next($request);
        } catch (\Exception $err) {
            return response(["msg" => "An exception occurred"], 500);
        }
    }
}
