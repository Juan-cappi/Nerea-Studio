<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRecepcionista
{

    public function handle(Request $request, Closure $next): Response
{
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role === 'recepcionista' || $user->roles->contains('name', 'admin') || $user->roles->contains('name', 'administrador')) {
            return $next($request);
        }

        return redirect()->route('cliente.perfil')->with('error', 'No tienes permisos para acceder a la sección de recepción.');
    }
}