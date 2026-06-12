<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Turno;

class Turnos extends Component
{
    public $servicio = 'Corte';
    public $profesional = 'Ana';
    public $diaSeleccionado = 1;
    public $horaSeleccionada = '10:00';
    public $mesActual = 5;  // Mayo
    public $anioActual = 2026; // Año actual del proyecto

    protected $rules = [
        'servicio' => 'required',
        'profesional' => 'required',
        'diaSeleccionado' => 'required|numeric|between:1,31',
        'horaSeleccionada' => 'required',
    ];

    public function mount()
    {
        // Inicialización si es necesaria
    }

    public function guardarTurno()
    {
        $this->validate();

        // 1. Validamos que el usuario esté autenticado
        if (!auth()->check()) {
            session()->flash('error', 'Debes iniciar sesión para reservar.');
            return redirect()->route('login');
        }

        // 2. Insertar en la base de datos
        Turno::create([
            'user_id' => auth()->id(),
            'servicio' => $this->servicio,
            'profesional' => $this->profesional,
            'fecha' => $this->anioActual . '-' . str_pad($this->mesActual, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->diaSeleccionado, 2, '0', STR_PAD_LEFT),
            'hora' => $this->horaSeleccionada,
        ]);

        // Redireccionar con un mensaje de éxito real
        session()->flash('message', '¡Turno confirmado con éxito!');
        return redirect()->route('home');
    }

    public function render()
    {
        $fechaInicio = Carbon::create($this->anioActual, $this->mesActual, 1);
        $totalDiasMes = $fechaInicio->daysInMonth;
        $diaSemanaInicio = $fechaInicio->dayOfWeek;
        
        // Calcular el offset para una grilla de 5 columnas (martes a sábado)
        // dayOfWeek: 0=dom, 1=lun, 2=mar, 3=mié, 4=jue, 5=vie, 6=sab
        if ($diaSemanaInicio >= 2 && $diaSemanaInicio <= 6) {
            $offset = $diaSemanaInicio - 2;
        } else {
            $offset = 0; // domingo y lunes empiezan en la próxima semana
        }
        
        // Calcular qué días están disponibles (martes a sábado)
        $diasDisponibles = [];
        for ($dia = 1; $dia <= $totalDiasMes; $dia++) {
            $fecha = Carbon::create($this->anioActual, $this->mesActual, $dia);
            $dayOfWeek = $fecha->dayOfWeek;
            if ($dayOfWeek >= 2 && $dayOfWeek <= 6) {
                $diasDisponibles[] = $dia;
            }
        }

        return view('livewire.turnos', [
            'totalDiasMes' => $totalDiasMes,
            'offset' => $offset,
            'anioActual' => $this->anioActual,
            'mesActual' => $this->mesActual,
            'diasDisponibles' => $diasDisponibles,
        ]);
    }
}
