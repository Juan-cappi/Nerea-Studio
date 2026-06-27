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
        // Trae los turnos simples para la vista (Tu lógica intacta)
        $turnosOcupados = \App\Models\Turno::select('fecha', 'hora')
            ->get()
            ->map(function($turno) {
                $fechaLimpia = date('Y-m-d', strtotime($turno->fecha));
                $horaLimpia = date('H:i', strtotime($turno->hora));
                return $fechaLimpia . '_' . $horaLimpia;
            })->toArray();

        // ✂️ Traemos los servicios dinámicos con su especialidad mapeada de la BD
        $servicios = Servicio::with('specialty')->get();

        $profesionales = Profesional::with('especialidades')->get();

        // 🎒 Enviamos las tres variables juntas a la vista 'turnos'
        return view('turnos', compact('turnosOcupados', 'profesionales', 'servicios'));
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

    // ==========================================
    // 📝 NUEVOS MÉTODOS PARA EL PERFIL DEL CLIENTE
    // ==========================================

    // 1. Muestra el formulario de edición pre-cargado
    public function edit($id)
    {
        // Buscamos el turno asegurándonos de que pertenezca al usuario por seguridad
        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $servicios = Servicio::with('specialty')->get();
        $profesionales = Profesional::with('especialidades')->get();
        
        $turnosOcupados = Turno::select('fecha', 'hora')->get()->map(function($t) {
            return date('Y-m-d', strtotime($t->fecha)) . '_' . date('H:i', strtotime($t->hora));
        })->toArray();

        return view('cliente.edit', compact('turno', 'servicios', 'profesionales', 'turnosOcupados'));
    }

    // 2. Procesa los cambios de la reprogramación
    public function update(Request $request, $id)
    {
        $request->validate([
            'servicio_id'    => 'required|exists:servicios,id',
            'profesional_id' => 'required|exists:profesionales,id',
            'fecha'          => 'required|date',
            'hora'           => 'required|string',
        ]);

        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        // Actualizamos respetando las columnas de tu tabla ('servicio' y 'profesional')
        $turno->update([
            'fecha'       => $request->fecha,
            'hora'        => $request->hora,
            'servicio'    => $request->servicio_id, 
            'profesional' => $request->profesional_id, 
        ]);

        return redirect()->route('cliente.perfil')->with('status', '¡Tu turno fue reprogramado con éxito!');
    }

    // 3. Borra/Cancela el turno
    public function cancel($id)
    {
        $turno = Turno::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $turno->delete();

        return redirect()->route('cliente.perfil')->with('status', 'El turno fue cancelado correctamente.');
    }
}