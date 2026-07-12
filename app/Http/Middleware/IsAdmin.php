<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

    
        if ($user->roles->contains('name', 'admin') || $user->roles->contains('name', 'administrador')) {
            return $next($request);
        }

        if ($user->role === 'recepcionista') {
            return redirect()->route('recepcionista.dashboard')->with('error', 'No tienes acceso al panel de administración.');
        }

        return redirect()->route('cliente.perfil')->with('error', 'No tienes permisos de administrador para acceder a esta sección.');
    }
}
