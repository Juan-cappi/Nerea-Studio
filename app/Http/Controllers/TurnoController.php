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

        // esto hace que no se puedan solapar los turnos y que lo redireccione al turno de nuevo cuando ponga confirmar
        $turnoExistente = \App\Models\Turno::where('fecha', $request->fecha)
                                           ->where('hora', $request->hora)
                                           ->first();
        
        if($turnoExistente){
            return redirect()->back()->withInput()->withErrors(['hora' => 'Lo sentimos, esta horario ya fue reservado por otro cliente']);
        }

        // 2. Insertamos usando las columnas EXACTAS de tu MySQL: 'servicio' y 'profesional'
        Turno::create([
            'user_id'     => auth()->id(), 
            'fecha'       => $dataValidada['fecha'],
            'hora'        => $dataValidada['hora'],
            'servicio'    => $dataValidada['servicio_id'], // Mapea a tu columna 'servicio'
            'profesional' => $request->input('profesional_id', 1), // Mapea a tu columna 'profesional'
            'estado '         => 'confirmado',
        ]);

        // 3. Redirección limpia al inicio con el cartel de éxito
        return redirect()->route('cliente.perfil')->with('status', '¡Tu turno ha sido reservado con éxito!');
    }

  public function create()
{
    $turnosOcupados = \App\Models\Turno::select('fecha', 'hora')
        ->get()
        ->map(function($turno) {
            // 🚨 FORZAMOS EL FORMATO YYYY-MM-DD (Evita que Carbon le meta el "00:00:00")
            $fechaLimpia = \Carbon\Carbon::parse($turno->fecha)->format('Y-m-d');
            $horaLimpia = date('H:i', strtotime($turno->hora));
            
            return $fechaLimpia . '_' . $horaLimpia;
        })->toArray();

    return view('turnos', compact('turnosOcupados'));
}

}