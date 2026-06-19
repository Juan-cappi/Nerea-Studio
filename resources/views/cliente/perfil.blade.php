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
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="#">Nosotros</a>

            <!-- 🔐 CONTROL DE ACCESO ADAPTATIVO -->
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