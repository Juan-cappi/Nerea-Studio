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
            <a href="{{ route('turnos') }}" class="active">Turnos</a>
            <a href="#">Nosotros</a>
            <a href="{{ route('login') }}">Log In</a>
        </nav>
    </header>

    <main class="split-screen-container">
        
        <div class="lado-imagen-salon"></div>

        <div class="lado-formulario-turno">
            
            <div class="card-reserva">
                <h2>Reserva tu Turno</h2>

                <form action="{{ route('turnos.store') }}" method="POST">
                    @csrf

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