<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Reprogramar Turno</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/css/admin.css'])
</head>
<body style="background-color: #f8f5f0; font-family: 'Montserrat', sans-serif; padding: 40px 0;">

    <div style="max-width: 500px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        
        <h2 style="font-family: 'Cormorant Garamond', serif; text-align: center; color: #3a3028; font-size: 2rem; margin-top: 0;">
            Reprogramar Turno
        </h2>

        <form action="{{ route('cliente.turnos.update', $turno->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- ◄ Avisa a Laravel que es una actualización -->

            <!-- 🔒 NOMBRE COMPLETO (Bloqueado y seguro) -->
            <div class="input-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">NOMBRE COMPLETO</label>
                <input type="text" name="nombre_completo" class="campo-input-unico" value="{{ auth()->user()->name }}" readonly style="background-color: #fcfbfa; color: #9c8470; width: 100%; height: 44px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px;">
            </div>

            <!-- 🔒 CORREO ELECTRÓNICO (Bloqueado y seguro) -->
            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">CORREO ELECTRÓNICO</label>
                <input type="email" name="correo" class="campo-input-unico" value="{{ auth()->user()->email }}" readonly style="background-color: #fcfbfa; color: #9c8470; width: 100%; height: 44px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px;">
            </div>

            <!-- ✂️ SELECTOR DE SERVICIOS DINÁMICOS -->
            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">SELECCIONÁ UN SERVICIO</label>
                <select name="servicio_id" id="servicio_select" class="campo-input-unico" required style="width: 100%; height: 44px; background: #fff; border: 1px solid #e8e0d6; border-radius: 6px; padding: 0 10px;">
                    <option value="" disabled>Seleccione un servicio</option>
                    @foreach($servicios as $ser)
                        <!-- Comparamos el ID del servicio con la columna 'servicio' de tu tabla -->
                        <option value="{{ $ser->id }}" {{ $turno->servicio == $ser->id ? 'selected' : '' }} data-especialidad="{{ $ser->specialty->nombre ?? '' }}">
                            {{ $ser->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 💇‍♂️ SELECTOR DE PROFESIONALES FILTRADOS -->
            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">PROFESIONAL</label>
                <select name="profesional_id" id="profesional_select" class="campo-input-unico" required style="width: 100%; height: 44px; background: #fff; border: 1px solid #e8e0d6; border-radius: 6px; padding: 0 10px;">
                    @foreach($profesionales as $pro)
                        @php
                            $stringSpecs = implode(',', $pro->especialidades->pluck('nombre')->toArray());
                        @endphp
                        <!-- Comparamos el ID del profesional con la columna 'profesional' de tu tabla -->
                        <option value="{{ $pro->id }}" {{ $turno->profesional == $pro->id ? 'selected' : '' }} data-especialidades="{{ strtolower($stringSpecs) }}">
                            {{ $pro->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 📅 NUEVA FECHA -->
            <div class="input-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">NUEVA FECHA</label>
                <input type="date" name="fecha" value="{{ $turno->fecha }}" class="campo-input-unico" required style="width: 100%; height: 44px; border: 1px solid #e8e0d6; border-radius: 6px; padding: 10px; box-sizing: border-box;">
            </div>

            <div class="input-group" style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 600; color: #6b5c4e;">NUEVA HORA</label>
                <select name="hora" id="hora_select" class="campo-input-unico" required style="width: 100%; height: 44px; border: 1px solid #e8e0d6; border-radius: 6px; padding: 0 10px; background: #fff;">
                    <option value="" disabled>Seleccione un horario</option>
                    @php
                        // Definimos la grilla de horarios oficiales del salón
                        $horariosSalon = ['09:00', '10:00', '11:00', '12:00', '16:00', '17:00', '18:00', '19:00'];
                        $horaActualTurno = date('H:i', strtotime($turno->hora));
                    @endphp
                    
                    @foreach($horariosSalon as $h)
                        <option value="{{ $h }}" {{ $horaActualTurno == $h ? 'selected' : '' }}>
                            {{ $h }} hs
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit" style="width: 100%; height: 48px; background-color: #5a4b41; color: white; border: none; border-radius: 25px; font-weight: 500; cursor: pointer; font-size: 14px; letter-spacing: 0.03em;">
                Confirmar Reprogramación
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('cliente.perfil') }}" style="color: #6b5c4e; text-decoration: none; font-size: 13px; font-weight: 500;">
                ← Volver al Perfil
            </a>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const servicioSelect = document.getElementById('servicio_select');
        const profesionalSelect = document.getElementById('profesional_select');
        const profesionalOptions = profesionalSelect.querySelectorAll('option');
        
        const fechaInput = document.querySelector('input[name="fecha"]');
        const horaSelect = document.getElementById('hora_select');
        const horaOptions = horaSelect.querySelectorAll('option');

        // 🗄️ Inyectamos el array de turnos ocupados enviado desde el controlador
        const turnosOcupados = @json($turnosOcupados);
        
        // Guardamos el turno original del cliente por si quiere mantener su misma fecha/hora
        const fechaOriginal = "{{ $turno->fecha }}";
        const horaOriginal = "{{ date('H:i', strtotime($turno->hora)) }}";

        // 1. Filtrado de Profesionales según el Servicio
        function filtrarProfesionales() {
            if(!servicioSelect.value) return;
            const especialidadRequerida = servicioSelect.options[servicioSelect.selectedIndex].getAttribute('data-especialidad').toLowerCase();
            
            profesionalOptions.forEach(option => {
                const specs = option.getAttribute('data-text-especialidades') || option.getAttribute('data-especialidades');
                if (specs && specs.includes(especialidadRequerida)) {
                    option.style.display = 'block';
                    option.disabled = false;
                } else {
                    option.style.display = 'none';
                    option.disabled = true;
                }
            });
        }

        // 2. Filtrado de Horarios ocupados según la Fecha elegida
        function filtrarHorarios() {
            const fechaElegida = fechaInput.value;
            if (!fechaElegida) return;

            horaOptions.forEach(option => {
                if (option.value === "") return;

                // Armamos el string llave (Ej: "2026-06-30_17:00")
                const llaveTurno = fechaElegida + '_' + option.value;

                // Si la combinación está ocupada por otro, la deshabilitamos
                // Pero le permitimos elegirla si es exactamente su turno original actual
                if (turnosOcupados.includes(llaveTurno) && !(fechaElegida === fechaOriginal && option.value === horaOriginal)) {
                    option.disabled = true;
                    option.textContent = option.value + ' hs (Ocupado)';
                    option.style.color = '#b5a496';
                } else {
                    option.disabled = false;
                    option.textContent = option.value + ' hs';
                    option.style.color = '#5a4b41';
                }
            });
        }

        // Listeners de eventos
        servicioSelect.addEventListener('change', function() {
            profesionalSelect.value = ""; 
            filtrarProfesionales();
        });

        fechaInput.addEventListener('change', function() {
            filtrarHorarios();
        });

        // Corremos los filtros al cargar la página por primera vez
        filtrarProfesionales();
        filtrarHorarios();
    });
</script>
</body>
</html>