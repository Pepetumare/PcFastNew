<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Revisa si el usuario está autenticado y si su rol es 'admin'.
        // La función 'isAdmin()' la crearemos en el modelo User.
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // Si no es admin, aborta la petición con un error 403 (Prohibido).
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
