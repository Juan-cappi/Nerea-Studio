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

                <!-- Botón de Cerrar Sesión -->
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
    <!-- Ponemos la etiqueta de la imagen apuntando a la carpeta public/img -->
    <img src="{{ asset('img/spa-turnos.jpeg') }}" alt="Nerea Spa" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>

        <div class="lado-formulario-turno">
            
            <div class="card-reserva">
                <h2>Reserva tu Turno</h2>

                <form action="{{ route('turnos.store') }}" method="POST">
                    @csrf
                 
             <!-- 🚨 CARTEL DE ERRORES (Aparece acá arriba si el turno ya está ocupado) -->
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

                    <p class="titulo-seccion-turno">Selecciona un día</p>
                    <div class="dias-horizontales">
                        <label><input type="radio" name="fecha" value="2026-06-16" required><span>Mar</span>16</label>
                        <label><input type="radio" name="fecha" value="2026-06-17"><span>Mié</span>17</label>
                        <label><input type="radio" name="fecha" value="2026-06-18"><span>Jue</span>18</label>
                        <label><input type="radio" name="fecha" value="2026-06-19"><span>Vie</span>19</label>
                        <label><input type="radio" name="fecha" value="2026-06-20"><span>Sáb</span>20</label>
                        <label><input type="radio" name="fecha" value="2026-06-23"><span>Mar</span>23</label>
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

                    <button type="submit" class="btn-confirmar">Confirmar Turno</button>
                </form>

            </div>
        </div>
    </main>
    <script>
    // 1. Recibimos el array de turnos ocupados que armamos en el TurnoController
    const turnosOcupados = @json($turnosOcupados ?? []);

    // 2. Capturamos todos los botones de fecha y hora del formulario
    const radiosFecha = document.querySelectorAll('input[name="fecha"]');
    const radiosHora = document.querySelectorAll('input[name="hora"]');

    function filtrarHorarios() {
        // Vemos cuál es la fecha que el usuario tiene seleccionada ahora mismo
        const fechaSeleccionada = document.querySelector('input[name="fecha"]:checked')?.value;
        
        if (!fechaSeleccionada) return;

        // Recorremos las horas una por una
        radiosHora.forEach(radio => {
            const horaValue = radio.value;
            // Armamos la combinacion idéntica a la del controlador (Ej: 2026-06-19_10:00)
            const combinacion = `${fechaSeleccionada}_${horaValue}`;
            const label = radio.closest('label'); // Buscamos el <label> que envuelve al radio

            if (turnosOcupados.includes(combinacion)) {
                // 🔒 SI ESTÁ OCUPADO: Lo deshabilitamos y lo tachamos visualmente
                radio.disabled = true;
                radio.checked = false; 
                if (label) {
                    label.style.opacity = '0.3';
                    label.style.textDecoration = 'line-through';
                    label.style.pointerEvents = 'none'; 
                }
            } else {
                // 🔓 SI ESTÁ LIBRE: Lo dejamos totalmente activo
                radio.disabled = false;
                if (label) {
                    label.style.opacity = '1';
                    label.style.textDecoration = 'none';
                    label.style.pointerEvents = 'auto';
                }
            }
        });
    }

    // Le decimos a los botones de fecha que ejecuten la función cada vez que cambien
    radiosFecha.forEach(radio => {
        radio.addEventListener('change', filtrarHorarios);
    });

    // Lo corremos apenas carga la página por si ya viene una fecha marcada
    document.addEventListener('DOMContentLoaded', filtrarHorarios);
</script>