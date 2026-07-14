<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    @vite(['resources/css/cliente.css', 'resources/css/admin.css'])
</head>
<body>

    <header>
     <a href="{{ url('/') }}" class="logo">
 <img src="{{ asset('img/Logo.jpg')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">    </a>
<nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>

            @auth
                @if(auth()->user()->esAdmin())
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                    
                @elseif(auth()->user()->esRecepcionista())
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

    @if(session('error'))
        <div style="max-width: 600px; margin: 2rem auto 0 auto; background-color: #fdf2f2; border: 1px solid #f5baba; color: #9b2c2c; padding: 15px 20px; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; gap: 10px;">
            <span>🛑</span>
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    @if(session('status'))
        <div style="max-width: 600px; margin: 2rem auto 0 auto; background-color: #faf8f5; border: 1px solid #e8e0d6; color: #5a4b41; padding: 15px 20px; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            ✨ <strong>{{ session('status') }}</strong>
        </div>
    @endif

    <div class="container-perfil">
        
        <div class="welcome-container">
            <h1>¡Hola, {{ auth()->user()->name }}!</h1>
            <p>Desde acá podés revisar tus turnos activos y tu historial de estética.</p>
            <a href="/turnos" class="btn-nuevo-turno">Reserva un nuevo turno</a>
        </div>

        {{-- PRÓXIMOS TURNOS --}}
        <div class="perfil-block">
            <h3>Tus próximos turnos</h3>
            
            @forelse($proximos as $turno)
                <div class="card-turno" style="display: flex; justify-content: space-between; align-items: center; background: #faf8f5; padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e8e0d6;">
                    <div>
                        <h4 style="margin: 0 0 8px 0; color: #3a3028; font-family: 'Cormorant Garamond', serif; font-size: 1.3rem;">
                            ✨ {{ $turno->elServicio->nombre ?? 'Servicio no encontrado' }}
                        </h4>
                        <p style="margin: 0; font-size: 13px; color: #6b5c4e;">
                            💇 Profesional: <strong>{{ $turno->elProfesional->nombre ?? 'No asignado' }}</strong>
                        </p>
                        <p style="margin: 5px 0 0 0; font-size: 13px; color: #9c8470;">
                            📅 {{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($turno->hora)->format('H:i') }} hs
                        </p>
                    </div>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <a href="{{ route('cliente.turnos.edit', $turno->id) }}" style="background-color: #6b5c4e; color: white; padding: 8px 16px; border-radius: 20px; text-decoration: none; font-size: 12px; font-weight: 500;">
                            MODIFICAR
                        </a>

                        <form action="{{ route('cliente.turnos.cancel', $turno->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que querés cancelar este turno?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #fff; color: #a94442; border: 1px solid #a94442; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-size: 12px; font-weight: 500;">
                                CANCELAR
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="texto-vacio">No tenés turnos reservados por el momento.</p>
            @endforelse

            {{ $proximos->links('vendor.pagination.nerea') }}
        </div>

        {{-- HISTORIAL --}}
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
                            @foreach($historial as $hist)
                                <tr style="border-bottom: 1px solid #f4eee8; color: #5a4b41;">
                                    <td style="padding: 12px 5px;">{{ \Carbon\Carbon::parse($hist->fecha)->format('d/m/Y') }}</td>
                                    <td style="padding: 12px 5px; font-weight: 500;">{{ $hist->elServicio->nombre ?? 'N/A' }}</td>
                                    <td style="padding: 12px 5px;">{{ $hist->elProfesional->nombre ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $historial->links('vendor.pagination.nerea') }}
            @endif
        </div>

    </div>

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