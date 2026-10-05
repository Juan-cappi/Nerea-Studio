<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TurnoController extends Controller
{
    public function create()
    {
        $servicios = Servicio::all();
        return view('turnos', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'apellido'    => 'required|string|max:255',
            'correo'      => 'required|email|max:255',
            'telefono'    => 'required|string|max:50',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        // Verificamos si el usuario ya existe por su correo, si no, lo creamos
        $usuario = User::where('email', $request->correo)->first();

        if (!$usuario) {
            User::create([
                'name'     => $request->nombre . ' ' . $request->apellido,
                'email'    => $request->correo,
                'password' => Hash::make('12345678'), // Contraseña temporal
            ]);
        }

        return redirect()->route('turnos')->with('success', '¡Solicitud generada con éxito!');
    }
}