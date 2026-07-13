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
            'servicio_id'     => 'required|exists:servicios,id',
            'profesional_id'  => 'required|exists:profesionales,id',
        ]);

        $servicio = Servicio::findOrFail($request->servicio_id);
        $duracion = $servicio->duracion;

        $horasAComprobar = [];
        $horaBase = date('H:i', strtotime($request->hora));
        $horasAComprobar[] = $horaBase;

        if ($duracion == 2) {
            $horasAComprobar[] = date('H:i', strtotime($horaBase . ' +1 hour'));
        }

        foreach ($horasAComprobar as $horaEvaluar) {
            $bloqueoDirecto = Turno::where('fecha', $request->fecha)
                                   ->where('hora', $horaEvaluar)
                                   ->where('profesional', $request->profesional_id)
                                   ->exists();

            $horaAnterior = date('H:i', strtotime($horaEvaluar . ' -1 hour'));
            $bloqueoPorExtension = Turno::where('fecha', $request->fecha)
                            ->where('hora', $horaAnterior)
                            ->where('profesional', $request->profesional_id)
                            ->whereHas('elServicio', function($query) { 
                                 $query->where('duracion', 2);
                            })->exists();

            if ($bloqueoDirecto || $bloqueoPorExtension) {
                return redirect()->back()->withInput()->withErrors(['hora' => 'Lo sentimos, el bloque horario requerido no está disponible.']);
            }
        }

        Turno::create([
            'user_id'     => auth()->id(), 
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

        $servicios = Servicio::with(['specialty'])->get();
        $profesionales = Profesional::with(['especialidades'])->get();

        return view('turnos', compact('turnosOcupados', 'profesionales', 'servicios'));
    }
    
    public function obtenerOcupados(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'servicio_id' => 'required|exists:servicios,id',
            'profesional_id' => 'nullable'
        ]);

        $servicioNuevo = Servicio::find($request->servicio_id);
        $duracionNueva = $servicioNuevo ? $servicioNuevo->duracion : 1; 

        $query = Turno::where('fecha', $request->fecha);
        if ($request->profesional_id) {
            $query->where('profesional', $request->profesional_id);
        }
        $turnosExistentes = $query->get();

        $horasOcupadas = [];

        foreach ($turnosExistentes as $turno) {
            $horaBaseStr = date('H:i', strtotime($turno->hora));
            $horasOcupadas[] = $horaBaseStr;

            $servicioViejo = Servicio::find($turno->servicio);
            $duracionVieja = $servicioViejo ? $servicioViejo->duracion : 1;

            if ($duracionVieja == 2) {
                $horaSiguiente = date('H:i', strtotime($horaBaseStr . ' +1 hour'));
                $horasOcupadas[] = $horaSiguiente;
            }
        }

        if ($duracionNueva == 2) {
            $grillaHoraria = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];
            
            foreach ($grillaHoraria as $horaActual) {
                if ($horaActual == '12:00') {
                    $horaSiguiente = '14:00';
                } else {
                    $horaSiguiente = date('H:i', strtotime($horaActual . ' +1 hour'));
                }

                if (in_array($horaSiguiente, $horasOcupadas)) {
                    $horasOcupadas[] = $horaActual;
                }
            }
            
            $horasOcupadas[] = '19:00'; 
        }

        $horasOcupadas = array_values(array_unique($horasOcupadas));

        return response()->json($horasOcupadas);
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