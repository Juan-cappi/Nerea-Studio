<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno; 

class TurnoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validamos los datos del formulario
        $dataValidada = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo'          => 'required|email|max:255',
            'servicio_id'     => 'required',
            'fecha'           => 'required|date',
            'hora'            => 'required|string',
        ]);

        // 2. Insertamos usando las columnas EXACTAS de tu MySQL: 'servicio' y 'profesional'
        Turno::create([
            'user_id'     => auth()->id(), 
            'fecha'       => $dataValidada['fecha'],
            'hora'        => $dataValidada['hora'],
            'servicio'    => $dataValidada['servicio_id'], // Mapea a tu columna 'servicio'
            'profesional' => $request->input('profesional_id', 1), // Mapea a tu columna 'profesional'
        ]);

        // 3. Redirección limpia al inicio con el cartel de éxito
        return redirect()->route('home')->with('status', '¡Tu turno ha sido reservado con éxito!');
    }
}