<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno; 
use App\Models\Servicio;
use App\Models\Profesional;
use Illuminate\Support\Facades\Mail;

class TurnoController extends Controller
{
    public function store(Request $request)
    {
        $dataValidada = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo'          => 'required|email|max:255',
            'fecha'           => 'required|date',
            'hora'            => 'required|string',
            'servicio_id'     => 'required',
            'profesional_id'  => 'required',
        ]);

        $turnoExistente = Turno::where('fecha', $request->fecha)
                               ->where('hora', $request->hora)
                               ->first();
        
        if($turnoExistente){
            return redirect()->back()->withInput()->withErrors(['hora' => 'Lo sentimos, este horario ya fue reservado por otro cliente.']);
        }

        // Guardamos el turno directo en XAMPP
        Turno::create([
            'user_id'     => auth()->id() ?? 1, 
            'fecha'       => $dataValidada['fecha'],
            'hora'        => $dataValidada['hora'],
            'servicio'    => $dataValidada['servicio_id'], 
            'profesional' => $dataValidada['profesional_id'], 
            'estado'      => 'confirmado', 
        ]);

        try {
            Mail::send('emails.turno-confirmado', ['turno' => $dataValidada], function($message) use ($dataValidada) {
                $message->to($dataValidada['correo'], $dataValidada['nombre_completo'])
                        ->subject('✨ Tu turno en Nerea Studio está confirmado ✨');
            });
        } catch (\Exception $e) {}

        return redirect()->route('cliente.perfil')->with('status', '¡Tu turno ha sido reservado con éxito!');
    }

    public function create()
    {
        $turnosOcupados = Turno::select('fecha', 'hora')->get()->map(function($turno) {
            return date('Y-m-d', strtotime($turno->fecha)) . '_' . date('H:i', strtotime($turno->hora));
        })->toArray();

        // Mantenemos las relaciones en inglés como las usa tu web.php
        $servicios = Servicio::with(['specialty'])->get();
        $profesionales = Profesional::with(['especialidades'])->get();

        return view('turnos', compact('turnosOcupados', 'profesionales', 'servicios'));
    }
    
    public function obtenerOcupados(Request $request)
    {
        $horas = Turno::where('fecha', $request->fecha)->pluck('hora')->map(function($hora) {
            return date('H:i', strtotime($hora));
        })->toArray();

        return response()->json($horas);
    }

    public function edit($id)
    {
        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $servicios = Servicio::with(['specialty'])->get();
        $profesionales = Profesional::with(['especialidades'])->get();
        
        $turnosOcupados = Turno::select('fecha', 'hora')->get()->map(function($t) {
            return date('Y-m-d', strtotime($t->fecha)) . '_' . date('H:i', strtotime($t->hora));
        })->toArray();

        return view('cliente.edit', compact('turno', 'servicios', 'profesionales', 'turnosOcupados'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'servicio_id'    => 'required|exists:servicios,id',
            'profesional_id' => 'required|exists:profesionales,id',
            'fecha'          => 'required|date',
            'hora'           => 'required|string',
        ]);

        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $turno->update([
            'fecha'       => $request->fecha,
            'hora'        => $request->hora,
            'servicio'    => $request->servicio_id, 
            'profesional' => $request->profesional_id, 
        ]);

        return redirect()->route('cliente.perfil')->with('status', '¡Tu turno fue reprogramado con éxito!');
    }

    public function cancel($id)
    {
        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $turno->delete();

        return redirect()->route('cliente.perfil')->with('status', 'El turno fue cancelado correctamente.');
    }
}