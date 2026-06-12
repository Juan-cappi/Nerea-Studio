<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil </title>
    
    
    @vite(['resources/css/cliente.css'])
</head>
<body>

    <!-- 🧭 Cabecera Unificada -->
    <header>
     <a href="{{ url('/') }}" class="logo">
        <div class="logo-circle"><span>N</span></div>
    </a>
        <nav>
            <a href="/">Inicio</a>
            <a href="/servicios">Servicios</a>
            <a href="/turnos">Sacar Turno</a>
            <a href="/perfil" class="active">Mi Perfil</a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </nav>
    </header>

    <!-- 🏢 Contenedor del Perfil -->
    <div class="container-perfil">
        
        <!-- Bloque de Bienvenida Estilo Títulos Principales -->
        <div class="welcome-container">
            <h1>¡Hola, {{ auth()->user()->name }}!</h1>
            <p>Desde acá podés revisar tus turnos activos y tu historial de estética.</p>
            <a href="/turnos" class="btn-nuevo-turno">Reserva un nuevo turno</a>
        </div>

        <!-- 📅 Próximos Turnos -->
        <div class="perfil-block">
            <h3>Tus próximos turnos</h3>
            
            @forelse($proximos as $turno)
                <div class="card-turno-cliente">
                    <div class="info-turno">
                        <h4>{{ $turno->servicio }}</h4>
                        <p>🧑‍🎨 Profesional: <strong>{{ $turno->profesional }}</strong></p>
                        <p>📆 {{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }} - {{ $turno->hora }} hs</p>
                    </div>
                    <div>
                        <button class="btn-cancelar-turno">Cancelar</button>
                    </div>
                </div>
            @empty
                <p class="texto-vacio">No tenés turnos programados en este momento.</p>
            @endforelse
        </div>

        <!-- 📋 Historial de Visitas -->
        <div class="perfil-block">
            <h3>Historial de visitas anteriores</h3>
            
            @if($historial->isEmpty())
                <p class="texto-vacio">Aún no registrás visitas en nuestro sistema.</p>
            @else
                <div class="tabla-contenedor-perfil">
                    <table class="tabla-perfil">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Servicio</th>
                                <th>Profesional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historial as $pasado)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pasado->fecha)->format('d/m/Y') }}</td>
                                    <td><strong>{{ $pasado->servicio }}</strong></td>
                                    <td>{{ $pasado->profesional }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- <footer> Idéntico al de tu layout general -->
    <footer>
        <div class="footer-col">
            <h4>Nerea Spa</h4>
            <p>Tu espacio de relax y estética.</p>
        </div>
        <div class="footer-col">
            <h4>Horarios</h4>
            <p>Martes a Sábado: 09:00 - 20:00</p>
        </div>
    </footer>

</body>
</html>