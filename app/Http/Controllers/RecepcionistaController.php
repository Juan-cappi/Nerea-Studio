<?php

namespace App\Http\Controllers;

use App\Models\Profesional;
use App\Models\Recepcionista;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\RecepcionistaRequest;

class RecepcionistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{

    $turnos = \App\Models\Turno::with(['user', 'elProfesional', 'elServicio'])
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                    ->paginate(10)
                    ->withQueryString();

    return view('admin.dashboard', compact('turnos'));
}

    public function dashboard(Request $request)
    {
        $fecha = $request->input('fecha', Carbon::today()->toDateString());
        $fechaCarbon = Carbon::parse($fecha);

        $profesionales = Profesional::orderBy('nombre')->get();
        $horariosBase = collect(range(9, 19))->map(fn ($hora) => sprintf('%02d:00', $hora))->values()->all();
        $turnosDelDia = Turno::whereDate('fecha', $fechaCarbon->toDateString())->get();

        $agendaProfesionales = $profesionales->map(function ($profesional) use ($turnosDelDia, $horariosBase) {
            $horarios = collect($horariosBase)->map(function ($hora) use ($turnosDelDia, $profesional) {
                $ocupado = $turnosDelDia->contains(function ($turno) use ($profesional, $hora) {
                    return $this->turnoPerteneceAProfesional($turno, $profesional)
                        && Carbon::parse($turno->hora)->format('H:i') === $hora;
                });

                return [
                    'hora' => $hora,
                    'estado' => $ocupado ? 'Ocupado' : 'Disponible',
                ];
            });

            return [
                'profesional' => $profesional,
                'horarios' => $horarios,
            ];
        });

        $totalTurnosDia = count($horariosBase) * $profesionales->count();

        $diasDelMes = collect(range(1, $fechaCarbon->daysInMonth))->map(function ($dia) use ($fechaCarbon, $profesionales, $horariosBase, $totalTurnosDia) {
            $date = $fechaCarbon->copy()->day($dia);
            $turnosDelDia = Turno::whereDate('fecha', $date->toDateString())->get();

            $ocupados = $turnosDelDia->filter(function ($turno) use ($profesionales, $horariosBase) {
                return collect($profesionales)->contains(function ($profesional) use ($turno) {
                    return $this->turnoPerteneceAProfesional($turno, $profesional);
                });
            })->map(function ($turno) {
                return strtolower(trim($turno->profesional)) . '|' . Carbon::parse($turno->hora)->format('H:i');
            })->unique()->count();

            $estadoCalendario = $ocupados === 0 ? 'available' : ($ocupados >= $totalTurnosDia ? 'full' : 'partial');

            return [
                'dia' => $dia,
                'fecha' => $date->toDateString(),
                'selected' => $date->toDateString() === $fechaCarbon->toDateString(),
                'estado' => $estadoCalendario,
            ];
        });

        return view('recepcionista.dashboard', compact('agendaProfesionales', 'fecha', 'diasDelMes', 'fechaCarbon'));
    }

    private function turnoPerteneceAProfesional($turno, Profesional $profesional): bool
    {
        $profesionalValores = collect([
            $profesional->id,
            $profesional->nombre,
            $profesional->Especialidad,
            $profesional->especialidad,
        ])->filter()->map(fn ($valor) => $this->normalizarTexto($valor))->all();

        $turnoValores = collect([
            $turno->profesional ?? null,
            $turno->profesional_id ?? null,
            $turno->profesional_nombre ?? null,
            $turno->profesional?->nombre ?? null,
        ])->filter()->map(fn ($valor) => $this->normalizarTexto($valor))->all();

        return collect($profesionalValores)->contains(function ($valor) use ($turnoValores) {
            return collect($turnoValores)->contains($valor);
        });
    }

    private function normalizarTexto($valor): string
    {
        if ($valor === null) {
            return '';
        }

        return strtolower(preg_replace('/[^a-z0-9]/i', '', (string) $valor));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.receptionist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecepcionistaRequest $request)
    {
        $validated = $request->validated();

        Recepcionista::create($validated);

        return redirect()->route('admin.dashboard')
        ->with('success','Recepcionista creado correctamente');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Recepcionista $recepcionista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recepcionista $recepcionista)
    {
        return view('admin.receptionist.edit', compact('recepcionista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecepcionistaRequest $request, Recepcionista $recepcionista)
    {
        $validated = $request->validated();

        $recepcionista->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success','Recepcionista actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recepcionista $recepcionista)
    {
        $recepcionista->delete();

        return redirect()->route('admin.dashboard')
            ->with('success','Recepcionista eliminado correctamente');
    }
}
