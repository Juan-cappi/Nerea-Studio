<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno; 
use Illuminate\Support\Facades\Mail;

class TurnoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validamos los datos obligatorios del formulario
        $dataValidada = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo'          => 'required|email|max:255',
            'fecha'           => 'required|date',
            'hora'            => 'required|string',
        ]);

        // Control de solapamiento estándar
        $turnoExistente = Turno::where('fecha', $request->fecha)
                               ->where('hora', $request->hora)
                               ->first();
        
        if($turnoExistente){
            return redirect()->back()->withInput()->withErrors(['hora' => 'Lo sentimos, este horario ya fue reservado por otro cliente.']);
        }

        // 2. Insertamos el turno normal de una (Estado confirmado)
        $nuevoTurno = Turno::create([
            'user_id'     => auth()->id() ?? 1, 
            'fecha'       => $dataValidada['fecha'],
            'hora'        => $dataValidada['hora'],
            'servicio'    => $request->input('servicio_id', 1), 
            'profesional' => $request->input('profesional_id', 1), 
            'estado'      => 'confirmado', 
        ]);

        // Envío de correo local con tu vista original
        Mail::send('emails.turno-confirmado', ['turno' => $nuevoTurno], function($message) use ($dataValidada) {
            $message->to($dataValidada['correo'], $dataValidada['nombre_completo'])
                    ->subject('✨ Tu turno en Nerea Studio está confirmado ✨');
        });

        // 3. Redirección directa a tu perfil con mensaje de éxito
        return redirect()->route('cliente.perfil')->with('status', '¡Tu turno ha sido reservado con éxito!');
    }

    public function create()
    {
        // Trae los turnos simples para la vista
        $turnosOcupados = Turno::select('fecha', 'hora')
            ->get()
            ->map(function($turno) {
                $fechaLimpia = \Carbon\Carbon::parse($turno->fecha)->format('Y-m-d');
                $horaLimpia = date('H:i', strtotime($turno->hora));
                return $fechaLimpia . '_' . $horaLimpia;
            })->toArray();

        return view('turnos', compact('turnosOcupados'));
    }
    
    public function obtenerOcupados(Request $request)
{
    // Buscamos solo las horas ocupadas para la fecha que el usuario clickeó
    $horas = Turno::where('fecha', $request->fecha)
                  ->pluck('hora')
                  ->map(function($hora) {
                      return date('H:i', strtotime($hora));
                  })
                  ->toArray();

    return response()->json($horas);
}
}