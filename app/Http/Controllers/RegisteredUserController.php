<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('registro');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Todo usuario que se registra por la web es CLIENTE
        $rolCliente = Role::firstOrCreate(['name' => 'cliente']);
        $user->roles()->attach($rolCliente->id);

        Auth::login($user);

        return redirect()->route('cliente.perfil')
            ->with('status', '¡Bienvenido/a a Nerea Studio!');
    }
}