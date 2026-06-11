<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Panel Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: #f9f5f0;
        }
        .sidebar {
            width: 220px;
            background: #fff;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            border-right: 1px solid #e8ddd4;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #6b5c4e;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .sidebar a:hover {
            background: #f9f5f0;
        }
        .sidebar a span.icon {
            font-size: 1.2rem;
        }
        .admin-content {
            flex: 1;
            padding: 2rem;
        }
        .admin-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            color: #6b5c4e;
            text-align: center;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .panel-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .panel-card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            color: #6b5c4e;
            text-align: center;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .role-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e8ddd4;
            border-radius: 12px;
            margin-bottom: 0.75rem;
        }
        .role-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #6b5c4e;
        }
        .role-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .role-count {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            color: #6b5c4e;
        }
        .btn-nuevo {
            background: #6b5c4e;
            color: #fff;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-nuevo:hover {
            background: #8b7355;
        }
        .profesionales-table {
            width: 100%;
            border-collapse: collapse;
        }
        .profesionales-table td {
            padding: 0.75rem 1rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            color: #6b5c4e;
            border-bottom: 1px solid #f0e8e0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .btn-accion {
            background: #6b5c4e;
            color: #fff;
            border: none;
            padding: 0.3rem 0.6rem;
            border-radius: 12px;
            font-size: 0.65rem;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-circle"><span>N</span></div>
    </a>
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="#">Servicios</a>
        <a href="{{ route('turnos') }}">Turnos</a>
        <a href="#">Nosotros</a>
        <a href="{{ route('login') }}">Log In</a>
    </nav>
</header>

<div class="admin-layout">

    {{-- Sidebar --}}
    <aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}">📊 Panel General</a>
    <a href="{{ route('profesionales.index') }}">💇‍♂️ Gestionar Profesionales</a>
    <a href="{{ route('recepcionistas.index') }}">📞 Gestionar Recepcionistas</a>
    <a href="#" class="disabled">👥 Clientes</a>
    <a href="#" class="disabled">💰 Precios y Servicios</a>
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