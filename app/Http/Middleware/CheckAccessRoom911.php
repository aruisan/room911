<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessRoom911
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Suponiendo que el usuario autenticado es un empleado
        $user = Auth::user();

        // Verificar si el campo access_allowed es true
        if ($user && $user->access_allowed) {
            return $next($request); // Permite el acceso
        }

        // Redirigir o retornar una respuesta de acceso denegado
        return redirect()->route('access.denied')->with('error', 'Access not allowed.');
    }
}
