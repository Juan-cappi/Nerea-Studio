<?php

use function Livewire\Volt\{state, rules, protect};
use Carbon\Carbon; // <-- Importante: esto para manejar fechas
use App\Models\Turno;

state([
    'servicio' => 'Corte',
    'profesional' => 'Ana',
    'diaSeleccionado' => '1',
    'horaSeleccionada' => '10:00',
    'mesActual' => 5,  // Mayo
    'añoActual' => 2026 // Año actual del proyecto
]);

// Validaciones 
rules([
    'servicio' => 'required',
    'profesional' => 'required',
    'diaSeleccionado' => 'required|numeric|between:1,31',
    'horaSeleccionada' => 'required',
]);

// Acción que se ejecuta al presionar "Confirmar Turno"
$guardarTurno = function() {
    $this->validate();

    // 1. Validamos que el usuario esté autenticado
    if (!auth()->check()) {
        session()->flash('error', 'Debes iniciar sesión para reservar.');
        return redirect()->route('login');
    }

    // 2. Insertar en la base de datos
    \App\Models\Turno::create([
        'user_id' => auth()->id(),
        'servicio' => $this->servicio,
        'profesional' => $this->profesional,
        'fecha' => '2026-05-' . str_pad($this->diaSeleccionado, 2, '0', STR_PAD_LEFT), // Ajustado al mayo del calendario
        'hora' => $this->horaSeleccionada,
    ]);

    // Redireccionar con un mensaje de éxito real
    session()->flash('message', '¡Turno confirmado con éxito!');
    return redirect()->route('home');
};

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu Turno - Nerea Studio</title>
    @vite(['resources/css/turnos.css', 'resources/js/turnos.js'])
</head>
<body>

 <header>
        <a href="{{ url('/') }}" class="logo">
        <div class="logo-circle"><span>N</span></div>
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="#">Servicios</a>
        <a href="{{ route('turnos') }}">Turnos</a>
        <a href="#">Nosotros</a>
        <a href="{{ route('login') }}">Log In</a>
    </nav>

</header>
    <main class="container-turnos">
        <h1>Reserva tu Turno</h1>
        <p class="subtitulo">Seleccioná el servicio y el turno que mejor se adapte a vos</p>

        <form wire:submit.prevent="guardarTurno" id= "form-turnos">
            <div class="selectores-group">
                <div class="control-select">
                    <label for="servicio">Servicio</label>
                    <select id="servicio" wire:model.live="servicio">
                        <option value="Corte">Corte - Diseñado a medida</option>
                        <option value="Balayage">Balayage - Sutil y elegante</option>
                        <option value="Alisado">Alisado - Liso y sedoso</option>
                        <option value="Nutrición">Nutrición Capilar</option>
                    </select>
                </div>
                <div class="control-select">
                    <label for="profesional">Profesional</label>
                   <select id="profesional" wire:model.live="profesional">
                        <option value="Ana">Ana</option>
                        <option value="Clara">Clara</option>
                        <option value="Barbi">Barbi</option>
                    </select>
                </div>
            </div>

<div class="agenda-block">
                <div class="calendario-dummy">
                    <h3>Seleccionar Fecha (Mayo 2026)</h3>
                    <div class="grid-dias">
                        <div class="dia-nombre">Ma</div>
                        <div class="dia-nombre">Mi</div>
                        <div class="dia-nombre">Ju</div>
                        <div class="dia-nombre">Vi</div>
                        <div class="dia-nombre">Sá</div>

                        <?php
                            $fechaInicio = Carbon::create($añoActual, $mesActual, 1);
                            $totalDiasMes = $fechaInicio->daysInMonth;
                            $diaSemanaInicio = $fechaInicio->dayOfWeek; 
                            $offset = ($diaSemanaInicio - 2 + 7) % 7; // Ajuste para grilla que arranca en Martes
                        ?>

                        <!-- Espacios vacíos necesarios para acomodar el primer día -->
                        @for ($i = 0; $i < $offset; $i++)
                            <div class="dia-vacio"></div>
                        @endfor

                        <!-- Renderizado dinámico de los días del mes -->
                        @for ($dia = 1; $dia <= $totalDiasMes; $dia++)
                            <div class="dia-numero {{ $diaSeleccionado == $dia ? 'selected' : '' }}" 
                                 wire:click="$set('diaSeleccionado', '{{ $dia }}')">
                                {{ $dia }}
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="horarios-dummy">
                    <h3>Horarios Disponibles</h3>
                    <div class="grid-horas">
                        @foreach(['09:00', '10:00', '11:00', '12:00', '13:00', '15:00', '16:00', '17:00', '18:00'] as $hora)
                            <button type="button" 
                                    class="hora-btn {{ $horaSeleccionada == $hora ? 'selected' : '' }}" 
                                    wire:click="$set('horaSeleccionada', '{{ $hora }}')">
                                {{ $hora }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

                <div class="btn-confirmar-container">
                    <button type="submit" class="btn-confirmar">Confirmar Turno</button>
                </div>
        </form>
    </main>

    <footer>
        <div class="footer-col">
            <h4>Nerea Studio</h4>
            <p>Belleza y experiencia personalizada.</p>
            <p style="margin-top: 10px;">&copy; 2026 Nerea Studio</p>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <p>Dirección del salón</p>
            <p>+54 11 1234 5678</p>
            <p>nerea@email.com</p>
        </div>
    </footer>
</body>
</html>