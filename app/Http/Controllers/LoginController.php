<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return match($user->role){
            'administrador'   => redirect()->route('admin.dashboard'),
            'recepcionista'   => redirect()->route('recepcionista.dashboard'),
            'cliente'         => redirect()->route('cliente.perfil'),
            'default'         => redirect()->route('dashboard'),
        };

    }
}