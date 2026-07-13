<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRecepcionista
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // El admin también entra al panel de recepción
        if ($user->esRecepcionista() || $user->esAdmin()) {
            return $next($request);
        }

        return redirect()->route('cliente.perfil')
            ->with('error', 'No tenés permisos para acceder a la sección de recepción.');
    }
}