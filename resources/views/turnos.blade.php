<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Reservar Turno</title>
    
    @vite(['resources/css/app.css', 'resources/css/registro.css', 'resources/css/turnos.css'])
</head>
<body>

    <header>
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-circle">
                <span>N</span>
            </div>
        </a>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="#">Nosotros</a>

            @auth
                @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'administrador') || auth()->user()->role === 'administrador')
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                    
                @elseif(auth()->user()->roles->contains('name', 'recepcionista') || auth()->user()->role === 'recepcionista')
                    <a href="/recepcionista/dashboard" class="btn-perfil-shortcut">Panel Recepción</a>
                    
                @else
                    <a href="{{ route('cliente.perfil') }}" class="btn-perfil-shortcut">Mi Perfil</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout" style="background: none; border: none; color: var(--color-texto); text-transform: uppercase; letter-spacing: 1px; font-size: 14px; margin-left: 20px; cursor: pointer; font-family: inherit;">Cerrar Sesión</button>
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
                        <div class="alert-errores-spa" style="background-color: #fce8e6; color: #a54040; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f7d4d1; font-family: inherit; font-size: 14px; font-weight: 500;">
                            @foreach ($errors->all() as $error)
                               <p style="margin: 0;">⚠️ {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- 👤 Input de Nombre Completo -->
                    <div class="input-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #6b5c4e;">NOMBRE COMPLETO</label>
                        <input type="text" name="nombre_completo" class="campo-input-unico" placeholder="Tu Nombre Completo" 
                            value="{{ auth()->check() ? auth()->user()->name : old('nombre_completo') }}" 
                            {{ auth()->check() ? 'readonly' : '' }} required>
                    </div>

                    <!-- ✉️ Input de Correo Electrónico -->
                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #6b5c4e;">CORREO ELECTRÓNICO</label>
                        <input type="email" name="correo" class="campo-input-unico" placeholder="Tu Correo" 
                            value="{{ auth()->check() ? auth()->user()->email : old('correo') }}" 
                            {{ auth()->check() ? 'readonly' : '' }} required>
                    </div>
                    <div class="input-group">
                        <select name="servicio" id="servicio_select" class="campo-input-unico" required>
                            <option value="" disabled selected>Seleccione un servicio</option>
                            
                            @foreach($servicios as $ser)
                                <option value="{{ $ser->nombre }}" data-especialidad="{{ $ser->specialty->nombre ?? '' }}">
                                    {{ $ser->nombre }}
                                </option>
                            @endforeach
                            
                        </select>
                    </div>

                    <!-- 2. Selector de Profesionales (Dinámico) -->
                    <div class="input-group" style="margin-top: 15px;">
                        <select name="profesional_id" id="profesional_select" class="campo-input-unico" required disabled>
                            <option value="" disabled selected>Primero seleccioná un servicio...</option>
                            
                            @foreach($profesionales as $pro)
                                @php
                                    // Juntamos todos los nombres de las especialidades de este profesional en una sola cadena separada por comas
                                    $especialidadesDelPro = $pro->especialidades->pluck('nombre')->toArray();
                                    $stringEspecialidades = implode(',', $especialidadesDelPro);
                                @endphp
                                
                                <!-- Guardamos las especialidades del profesional en minúsculas para comparar fácil en JS -->
                                <option value="{{ $pro->id }}" data-especialidades="{{ strtolower($stringEspecialidades) }}" style="display: none;">
                                    {{ $pro->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <p class="titulo-seccion-turno">Selecciona un día de {{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
                    <div class="dias-horizontales">
                        @php
                            $hoy = \Carbon\Carbon::now();
                            $ultimoDiaMes = \Carbon\Carbon::now()->endOfMonth()->day;
                        @endphp

                        @for ($dia = $hoy->day; $dia <= $ultimoDiaMes; $dia++)
                            @php
                                $fechaBucle = \Carbon\Carbon::create($hoy->year, $hoy->month, $dia);
                                $nombreDia = $fechaBucle->translatedFormat('D');
                            @endphp
                    
                            <label>
                                <input type="radio" name="fecha" value="{{ $fechaBucle->format('Y-m-d') }}" required>
                                <span>{{ ucfirst($nombreDia) }}</span>{{ $dia }}
                            </label>
                        @endfor
                    </div>

                    <p class="titulo-seccion-turno">Selecciona la hora</p>
                    <div class="horas-grilla-cuatro">
                        <label><input type="radio" name="hora" value="09:00" required>09:00</label>
                        <label><input type="radio" name="hora" value="10:00">10:00</label>
                        <label><input type="radio" name="hora" value="11:00">11:00</label>
                        <label><input type="radio" name="hora" value="12:00">12:00</label>
                        <label><input type="radio" name="hora" value="16:00" required>16:00</label>
                        <label><input type="radio" name="hora" value="17:00">17:00</label>
                        <label><input type="radio" name="hora" value="18:00">18:00</label>
                        <label><input type="radio" name="hora" value="19:00">19:00</label>
                    </div>
                    <div class="aviso-pago-seguro" style="background-color: #fcf8f2; border-left: 4px solid #d4af37; padding: 15px; border-radius: 6px; margin: 20px 0; font-family: inherit; text-align: left;">
                        <p style="margin: 0 0 5px 0; font-weight: 600; color: #333; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                            🔒 Reserva Asegurada (Seña del 20%)
                        </p>
                        <p style="margin: 0; color: #666; font-size: 13px; line-height: 1.4;">
                            Para garantizar tu lugar en el salón, se solicita el pago de una <strong>seña del 20%</strong> mediante Mercado Pago. El monto restante se cancelará en el local el día del servicio.
                        </p>
                    </div>
                    <button type="submit" class="btn-confirmar">Confirmar Turno</button>
                </form>

            </div>
        </div>
    </main>
</body>
</html>

<script>
    function actualizarHorarios() {
        const fechaSeleccionada = document.querySelector('input[name="fecha"]:checked')?.value;
        if (!fechaSeleccionada) return;

        // Le preguntamos al controlador qué horas están tomadas para esa fecha
        fetch(`/turnos/ocupados?fecha=${fechaSeleccionada}`)
            .then(res => res.json())
            .then(horasOcupadas => {
                const radiosHora = document.querySelectorAll('input[name="hora"]');
                
                // Hora actual por si es el día de hoy
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
                        if (label) label.style.display = 'none'; // Desaparece si está ocupado
                    } else {
                        radio.disabled = false;
                        if (label) label.style.display = ''; // Reaparece centrado con tu CSS original
                    }
                });
            });
    }

    // ... Tu función actualizarHorarios() termina impecable en la línea 173

    // 💇‍♂️ NUEVA FUNCIÓN: Filtra los profesionales según la especialidad del servicio
    function filtrarProfesionales() {
        const selectServicio = document.querySelector('select[name="servicio_id"]');
        const selectProfesional = document.getElementById('profesional_id');
        if (!selectServicio || !selectProfesional) return;

        const servicioElegido = selectServicio.value; // ID de la especialidad/servicio

        if (!servicioElegido) {
            selectProfesional.disabled = true;
            selectProfesional.value = "";
            return;
        }

        // Habilitamos el combo de profesionales
        selectProfesional.disabled = false;
        const opciones = selectProfesional.querySelectorAll('option');
        
        opciones.forEach(option => {
            if (option.value === "") return; // Al placeholder no lo tocamos

            const espId = option.getAttribute('data-especialidad');
            if (espId === servicioElegido) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    }

    // 🔄 Bloque DOMContentLoaded unificado y actualizado
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('change', function (e) {
            // Tu lógica existente para las fechas (No se toca)
            if (e.target && e.target.name === 'fecha') {
                actualizarHorarios();
            }
            
            // ⚡ NUEVO: Detecta cuando cambian el servicio para filtrar el peluquero/colorista
            if (e.target && e.target.name === 'servicio_id') {
                filtrarProfesionales();
            }
        });

        // Corremos ambas funciones al arrancar por si ya viene algo seleccionado
        actualizarHorarios();
        filtrarProfesionales();
    });
    document.addEventListener('DOMContentLoaded', function () {
    const servicioSelect = document.getElementById('servicio_select');
    const profesionalSelect = document.getElementById('profesional_select');
    const profesionalOptions = profesionalSelect.querySelectorAll('option');

    servicioSelect.addEventListener('change', function () {
        // 1. Obtenemos la especialidad requerida por el servicio seleccionado (en minúsculas)
        const especialidadRequerida = this.options[this.selectedIndex].getAttribute('data-especialidad').toLowerCase();

        // 2. Habilitamos el selector de profesionales y reseteamos su selección
        profesionalSelect.disabled = false;
        profesionalSelect.value = "";
        profesionalSelect.options[0].textContent = "Seleccione un profesional...";

        // 3. Recorremos los profesionales y filtramos
        profesionalOptions.forEach(option => {
            // Saltamos la opción por defecto ("Primero seleccioná...")
            if (option.value === "") return;

            const especialidadesDelPro = option.getAttribute('data-especialidades');

            // Si el profesional tiene la especialidad requerida, lo mostramos
            if (especialidadesDelPro.includes(especialidadRequerida)) {
                option.style.display = 'block';
                option.disabled = false;
            } else {
                option.style.display = 'none';
                option.disabled = true;
            }
        });
    });
});
</script>