<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Panel Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css','resources/css/admin.css','resources/js/registro.js'])
    
</head>
<body>

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

<div class="admin-layout">

    {{-- Sidebar --}}
    <aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}">📊 Panel General</a>
    <a href="{{ route('profesionales.index') }}">💇‍♂️ Gestionar Profesionales</a>
    <a href="{{ route('recepcionista.dashboard') }}">📞 Gestionar Recepcionistas</a>
    <a href="#" class="disabled">👥 Clientes</a>
    <a href="/servicios" class="disabled">💰 Precios y Servicios</a>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn-accion" style="border: none; cursor: pointer; background-color: #333; color: white;" > 🚪 Cerrar Sesión </button>
    </form>
    </aside>

    {{-- Contenido --}}
    <div class="admin-content">
        <h1 class="admin-title">Panel de Administrador</h1>

        {{-- Panel Profesionales --}}
        <div class="panel-card">
            <div class="panel-card-title">Panel Profesionales</div>

            <div class="role-row">
                <span class="role-name">Recepcionista</span>
                <div class="role-right">
                    <span class="role-count">{{ $totalRecepcionistas }}</span>
                    <a href="{{route('recepcionistas.create')}}" class="btn-nuevo">+ Nuevo Recepcionista</a>
                </div>
            </div>

            <div class="role-row">
                <span class="role-name">Profesional</span>
                <div class="role-right">
                    <span class="role-count">{{ $totalProfesionales }}</span>
                    <a href="{{route('profesionales.create')}}" class="btn-nuevo">+ Nuevo Profesional</a>
                </div>
            </div>
        </div>

        {{-- Listado de Profesionales --}}
        <div class="panel-card">
            <div class="panel-card-title">Listado de Profesionales</div>
            <table class="profesionales-table">
                @foreach($profesionales as $profesional)
                <tr>
                    <td>{{ $profesional->nombre }}</td>
                    <td>{{ $profesional->email }}</td>
                    <td>{{ $profesional->telefono ?? '-' }}</td>
                    <td>{{ $profesional->Especialidad ?? 'Sin definir'}}</td>
                    <td>    
                        
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('profesionales.edit', $profesional->id) }}" class="btn-accion">Editar</a>

        <form action="{{ route('profesionales.destroy', $profesional->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar a este profesional?');" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-accion" style="border: none; cursor: pointer; background-color: #333; color: white;">Borrar</button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </table>
        </div>
        {{-- Listado de Recepcionistas --}}
        <div class="panel-card">
            <div class="panel-card-title">Listado de recepcionistas</div>
            <table class="profesionales-table">
                @foreach($recepcionistas as $recepcionista)
                <tr>
                    <td>{{ $recepcionista->nombre }}</td>
                    <td>{{ $recepcionista->email }}</td>
                    <td>{{ $recepcionista->telefono ?? '-' }}</td>
                    <td>
                        
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('recepcionistas.edit', $recepcionista->id) }}" class="btn-accion">Editar</a>

        <form action="{{ route('recepcionistas.destroy', $recepcionista->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar a este recepcionista?');" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-accion" style="border: none; cursor: pointer; background-color: #333; color: white;">Borrar</button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
    
</body>
</html>