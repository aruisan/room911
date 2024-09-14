<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
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
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Verifica si el usuario tiene el type correcto
            if (Auth::user()->type === 'admin_room_911') {
                return $next($request);
            }
        }

        // Asegúrate de que este redirect sea correcto:
        return back()->with('error', 'No tienes acceso a esta sección.');
    }
}
