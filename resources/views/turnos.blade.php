<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Reservar Turno</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/home.css', 'resources/css/registro.css', 'resources/css/turnos.css'])

    <style>
        .card-reserva {
            padding-bottom: 40px !important;
            margin-bottom: 20px !important;
            background: #fbf8f3;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #e6dec1;
        }
        .split-screen-container {
            min-height: 100vh;
            height: auto !important;
            background-color: #f4eee6;
        }
    </style>
</head>
<body>

    <header>
        <a href="{{ route('home') }}" class="logo">
         <img src="{{ asset('img/Logo.jpg')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">
        </a>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>

            @auth
                @if(auth()->user()->esAdmin())
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                @elseif(auth()->user()->esRecepcionista())
                    <a href="/recepcionista/dashboard" class="btn-perfil-shortcut">Panel Reception</a>
                @else
                    <a href="{{ route('cliente.perfil') }}" class="btn-perfil-shortcut">Mi Perfil</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Ingresar</a>
            @endauth
        </nav>
    </header>

    <main class="split-screen-container">
        <div class="lado-imagen-salon">
            <img src="{{ asset('img/spa-turnos.jpeg') }}" alt="Nerea Spa" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>

        <div class="lado-formulario-turno">
            <div class="card-reserva">
                <h2>Reserva tu Turno</h2>

                <form action="{{ route('turnos.store') }}" method="POST">
                    @csrf
                 
                    @if ($errors->any())
                        <div class="alert-errores-spa" style="background-color: #fce8e6; color: #a54040; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f7d4d1; font-size: 14px; font-weight: 500;">
                            @foreach ($errors->all() as $error)
                               <p style="margin: 0;">⚠️ {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="input-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">NOMBRE COMPLETO</label>
                        <input type="text" name="nombre_completo" class="campo-input-unico" placeholder="Tu Nombre Completo" 
                            value="{{ auth()->check() ? auth()->user()->name : old('nombre_completo') }}" 
                            {{ auth()->check() ? 'readonly' : '' }} required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">CORREO ELECTRÓNICO</label>
                        <input type="email" name="correo" class="campo-input-unico" placeholder="Tu Correo" 
                            value="{{ auth()->check() ? auth()->user()->email : old('correo') }}" 
                            {{ auth()->check() ? 'readonly' : '' }} required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <select name="servicio_id" id="servicio_select" class="campo-input-unico" required style="border-radius: 4px;">
                            <option value="" disabled selected>Seleccione un servicio</option>
                            @foreach($servicios as $ser)
                                <!-- 🔒 CORRECCIÓN: Usamos la relación 'especialidad' en español tal como está en el modelo -->
                                <option value="{{ $ser->id }}" data-especialidad="{{ $ser->especialidad->nombre ?? '' }}">
                                    {{ $ser->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <select name="profesional_id" id="profesional_select" class="campo-input-unico" required disabled style="border-radius: 4px;">
                            <option value="" disabled selected>Primero seleccioná un servicio...</option>
                            @foreach($profesionales as $pro)
                                @php
                                    $especialidadesDelPro = $pro->especialidades->pluck('nombre')->toArray();
                                    $stringEspecialidades = implode(',', $especialidadesDelPro);
                                @endphp
                                <option value="{{ $pro->id }}" data-especialidades="{{ strtolower($stringEspecialidades) }}" style="display: none;">
                                    {{ $pro->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @php
                        $mesSeleccionado = request('mes', \Carbon\Carbon::now()->month);
                        $anioSeleccionado = request('anio', \Carbon\Carbon::now()->year);
                        $fechaObjeto = \Carbon\Carbon::create($anioSeleccionado, $mesSeleccionado, 1);
                    @endphp

                    <div class="header-calendario-interactivo" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; margin-bottom: 15px;">
                        <p class="titulo-seccion-turno" style="margin: 0;">Selecciona un día de {{ ucfirst($fechaObjeto->translatedFormat('F Y')) }}</p>
                        
                        <select id="selector_mes_turno" class="campo-input-unico" style="width: auto; padding: 5px 10px; margin: 0; border-radius: 4px;" onchange="cambiarMesCalendario()">
                            @for ($m = 0; $m < 6; $m++)
                                @php
                                    $mesOpcion = \Carbon\Carbon::now()->addMonths($m);
                                @endphp
                                <option value="{{ $mesOpcion->month }}" data-anio="{{ $mesOpcion->year }}" {{ $mesSeleccionado == $mesOpcion->month ? 'selected' : '' }}>
                                    {{ ucfirst($mesOpcion->translatedFormat('F Y')) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="dias-horizontales">
                        @php
                            $hoy = \Carbon\Carbon::now();
                            $diaInicio = ($mesSeleccionado == $hoy->month && $anioSeleccionado == $hoy->year) ? $hoy->day : 1;
                            $ultimoDiaMes = $fechaObjeto->endOfMonth()->day;
                        @endphp

                       @for ($dia = $diaInicio; $dia <= $ultimoDiaMes; $dia++)
                        @php
                            $fechaBucle = \Carbon\Carbon::create($anioSeleccionado, $mesSeleccionado, $dia);
                            $nombreDia = $fechaBucle->translatedFormat('D');
                            $esDiaInvalido = ($fechaBucle->dayOfWeek === 0 || $fechaBucle->dayOfWeek === 1);
                        @endphp
                        @continue($esDiaInvalido)
                        <label>
                            <input type="radio" name="fecha" value="{{ $fechaBucle->format('Y-m-d') }}" required 
                                {{ request('fecha') == $fechaBucle->format('Y-m-d') ? 'checked' : '' }}>
                            <span>{{ ucfirst($nombreDia) }}</span>{{ $dia }}
                        </label>
                    @endfor
                    </div>

                    <p class="titulo-seccion-turno" style="margin-top: 20px;">Selecciona la hora</p>
                    <div class="horas-grilla-cuatro">
                        @php
                            $horaActual = \Carbon\Carbon::now('-03:00')->format('H:i');
                        @endphp
                        <label style="{{ $horaActual >= '09:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="09:00" required {{ $horaActual >= '09:00' ? 'disabled' : '' }}>09:00</label>
                        <label style="{{ $horaActual >= '10:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="10:00" {{ $horaActual >= '10:00' ? 'disabled' : '' }}>10:00</label>
                        <label style="{{ $horaActual >= '11:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="11:00" {{ $horaActual >= '11:00' ? 'disabled' : '' }}>11:00</label>
                        <label style="{{ $horaActual >= '12:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="12:00" {{ $horaActual >= '12:00' ? 'disabled' : '' }}>12:00</label>
                        <label style="{{ $horaActual >= '16:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="16:00" required {{ $horaActual >= '16:00' ? 'disabled' : '' }}>16:00</label>
                        <label style="{{ $horaActual >= '17:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="17:00" {{ $horaActual >= '17:00' ? 'disabled' : '' }}>17:00</label>
                        <label style="{{ $horaActual >= '18:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="18:00" {{ $horaActual >= '18:00' ? 'disabled' : '' }}>18:00</label>
                        <label style="{{ $horaActual >= '19:00' ? 'display: none;' : '' }}"><input type="radio" name="hora" value="19:00" {{ $horaActual >= '19:00' ? 'disabled' : '' }}>19:00</label>
                    </div>

                    <div class="aviso-pago-seguro" style="background-color: #fcf8f2; border-left: 4px solid #c5a059; padding: 15px; border-radius: 6px; margin: 20px 0; text-align: left;">
                        <p style="margin: 0 0 5px 0; font-weight: 600; color: #2a2521; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                            ✨ Reserva Directa en Línea
                        </p>
                        <p style="margin: 0; color: #6a6156; font-size: 13px; line-height: 1.4;">
                            Estás registrando tu turno de forma directa. El pago total del servicio se realizará en el local el día de tu cita. ¡Te esperamos!
                        </p>
                    </div>
                        <button type="button" class="btn-confirmar" onclick="abrirConfirmacion()">
                        Confirmar Turno
                        </button>
                </form>
            </div>
        </div>
    </main>

    <div id="modal_confirmacion_turno" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; justify-content: center; align-items: center; backdrop-filter: blur(3px);">
        <div style="background: white; padding: 30px; border-radius: 8px; max-width: 420px; width: 90%; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="font-size: 40px; margin-bottom: 15px;">🔒</div>
            <h3 style="margin: 0 0 10px 0; color: #2a2521; font-size: 22px; font-weight: 600;">¿Confirmar tu Reserva?</h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 25px; line-height: 1.5; text-align: left;">
                Estás por agendar tu turno en <strong>Nerea Studio</strong>. Al confirmar, tu cita quedará registrada de inmediato en nuestro sistema de atención.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="cerrarConfirmacion()" style="background: #f0f0f0; color: #444; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px; flex: 1;">Modificar</button>
                <button type="button" onclick="enviarFormularioTurno()" style="background: #2a2521; color: white; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px; flex: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">Confirmar</button>
            </div>
        </div>
    </div>

</body>
</html>

<script>
    function cambiarMesCalendario() {
        const selector = document.getElementById('selector_mes_turno');
        const mes = selector.value;
        const anio = selector.options[selector.selectedIndex].getAttribute('data-anio');
        window.location.href = `?mes=${mes}&anio=${anio}`;
    }

    function abrirConfirmacion() {
        const form = document.querySelector('.card-reserva form');
        if (!form.checkValidity()) {
            form.reportValidity(); 
            return;
        }
        document.getElementById('modal_confirmacion_turno').style.display = 'flex';
    }

    function cerrarConfirmacion() {
        document.getElementById('modal_confirmacion_turno').style.display = 'none';
    }

    function enviarFormularioTurno() {
        const form = document.querySelector('.card-reserva form');
        if (form) {
            form.submit();
        }
    }

    function actualizarHorarios() {
        const radioFecha = document.querySelector('input[name="fecha"]:checked');
        const fechaSeleccionada = radioFecha?.value;
        if (!fechaSeleccionada) return;

        const servicioSelect = document.getElementById('servicio_select');
        const servicioId = servicioSelect ? servicioSelect.value : '';

        const profesionalSelect = document.getElementById('profesional_select');
        const profesionalId = profesionalSelect ? profesionalSelect.value : '';

        if (!servicioId) {
            const radiosHora = document.querySelectorAll('input[name="hora"]');
            radiosHora.forEach(radio => {
                radio.disabled = true;
                const label = radio.closest('label');
                if (label) label.style.display = 'none';
            });
            return;
        }

        fetch(`/turnos/ocupados?fecha=${fechaSeleccionada}&servicio_id=${servicioId}&profesional_id=${profesionalId}`)
            .then(res => res.json())
            .then(horasOcupadas => {
                const radiosHora = document.querySelectorAll('input[name="hora"]');
                const ahora = new Date();
                const fechaHoy = `${ahora.getFullYear()}-${String(ahora.getMonth() + 1).padStart(2, '0')}-${String(ahora.getDate()).padStart(2, '0')}`;
                const horaActual = `${String(ahora.getHours()).padStart(2, '0')}:${String(ahora.getMinutes()).padStart(2, '0')}`;

                radiosHora.forEach(radio => {
                    const horaValue = radio.value;
                    const label = radio.closest('label');
                    const estaOcupado = horasOcupadas.includes(horaValue);
                    const yaPaso = (fechaSeleccionada === fechaHoy && horaValue <= horaActual);

                    if (estaOcupado || yaPaso) {
                        radio.disabled = true;
                        radio.checked = false;
                        if (label) label.style.display = 'none';
                    } else {
                        radio.disabled = false;
                        if (label) label.style.display = '';
                    }
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const servicioSelect = document.getElementById('servicio_select');
        const profesionalSelect = document.getElementById('profesional_select');
        const profesionalOptions = profesionalSelect.querySelectorAll('option');

        document.addEventListener('change', function (e) {
            if (e.target && e.target.name === 'fecha') {
                actualizarHorarios();
            }
        });

        if (servicioSelect) {
            servicioSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const especialidadRequerida = selectedOption.getAttribute('data-especialidad')?.toLowerCase().trim();

                profesionalSelect.disabled = false;
                profesionalSelect.value = "";
                profesionalSelect.options[0].textContent = "Seleccione un profesional...";

                profesionalOptions.forEach(option => {
                    if (option.value === "") return;
                    const especialidadesDelPro = option.getAttribute('data-especialidades')?.toLowerCase().trim();

                    if (especialidadesDelPro && (especialidadesDelPro.includes(especialidadRequerida) || (especialidadRequerida && especialidadRequerida.includes(especialidadesDelPro)))) {
                        option.style.display = 'block';
                        option.disabled = false;
                    } else {
                        option.style.display = 'none';
                        option.disabled = true;
                    }
                });

                actualizarHorarios();
            });
        }

      if (profesionalSelect) {
            profesionalSelect.addEventListener('change', function () {
                actualizarHorarios();
            });
        }

        const radiosFechaValidos = document.querySelectorAll('input[name="fecha"]:not([disabled])');
        if (radiosFechaValidos.length > 0 && !document.querySelector('input[name="fecha"]:checked')) {
            radiosFechaValidos[0].checked = true;
        }

    
        setTimeout(actualizarHorarios, 100); 
    });
</script>
    
</script>