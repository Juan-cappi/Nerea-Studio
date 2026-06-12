<?php
    $anioActual = isset($anioActual) ? $anioActual : date('Y');
    $mesActual = isset($mesActual) ? $mesActual : 5;
    $diaSeleccionado = isset($diaSeleccionado) ? $diaSeleccionado : 1;
    $horaSeleccionada = isset($horaSeleccionada) ? $horaSeleccionada : '10:00';
    $totalDiasMes = $totalDiasMes ?? 31;
    $offset = $offset ?? 0;
?>

<div>
    <form wire:submit.prevent="guardarTurno" id="form-turnos">
        <div class="selectores-group">
            <div class="control-select">
                <label for="servicio">Servicio</label>
                <select id="servicio" wire:model="servicio">
                    <option value="Corte">Corte - Diseñado a medida</option>
                    <option value="Balayage">Balayage - Sutil y elegante</option>
                    <option value="Alisado">Alisado - Liso y sedoso</option>
                    <option value="Nutrición">Nutrición Capilar</option>
                </select>
            </div>
            <div class="control-select">
                <label for="profesional">Profesional</label>
                <select id="profesional" wire:model="profesional">
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
                    <div class="dia-nombre">Mar</div>
                    <div class="dia-nombre">Mié</div>
                    <div class="dia-nombre">Jue</div>
                    <div class="dia-nombre">Vie</div>
                    <div class="dia-nombre">Sab</div>

                    @for ($i = 0; $i < $offset; $i++)
                        <div class="dia-vacio"></div>
                    @endfor

                    @foreach ($diasDisponibles as $dia)
                        <button type="button" 
                                class="dia-numero {{ $diaSeleccionado == $dia ? 'selected' : '' }}" 
                                wire:click="$set('diaSeleccionado', {{ $dia }})">
                            {{ $dia }}
                        </button>
                    @endforeach
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
</div>
</div>
