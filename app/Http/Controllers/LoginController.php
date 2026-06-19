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

  
        
        if ($user->role === 'administrador' || $user->role === 'admin' || ($user->roles && ($user->roles->contains('name', 'admin') || $user->roles->contains('name', 'administrador')))) {
            return redirect()->route('admin.dashboard');
        }


        if ($user->role === 'recepcionista' || ($user->roles && $user->roles->contains('name', 'recepcionista'))) {
            return redirect()->route('recepcionista.dashboard');
        }

        return redirect()->route('cliente.perfil');

    }
}