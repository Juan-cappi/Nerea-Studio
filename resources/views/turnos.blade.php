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

                    <input type="text" name="nombre_completo" placeholder="Nombre Completo" class="campo-input-unico" value="{{ old('nombre_completo') }}" required>
                    
                    <input type="email" name="correo" placeholder="Correo Electrónico" class="campo-input-unico" value="{{ old('correo') }}" required>

                    <select name="servicio_id" class="campo-input-unico" required>
                        <option value="">Seleccione un servicio</option>
                        <option value="1">Corte</option>
                        <option value="2">Balayage</option>
                        <option value="3">Alisado</option>
                        <option value="4">Nutrición</option>
                    </select>

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

    document.addEventListener('DOMContentLoaded', function () {
        // Cada vez que cambien de fecha, ejecutamos la consulta al servidor
        document.addEventListener('change', function (e) {
            if (e.target && e.target.name === 'fecha') {
                actualizarHorarios();
            }
        });

        // Ejecutar al cargar la página por primera vez
        actualizarHorarios();
    });
</script>