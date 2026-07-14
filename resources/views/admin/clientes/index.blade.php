<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Gestión de Clientes</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/css/admin.css'])
</head>
<body style="display: block; background-color: #f8f5f0; margin: 0; padding: 0;">

<header>
    <a href="{{ url('/') }}" class="logo">
        <img src="{{ asset('img/Logo.jpg')}}" alt="Logo Nerea" style="height: 80px; width: auto; object-fit: contain; mix-blend-mode: multiply;">
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
                <a href="/recepcionista/dashboard" class="btn-perfil-shortcut">Panel Recepción</a>
            @else
                <a href="{{ route('cliente.perfil') }}" class="btn-perfil-shortcut">Mi Perfil</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" class="btn-logout" style="background: none; border: none; color: var(--color-texto); text-transform: uppercase; letter-spacing:1px; font-size: 14px; margin-left: 20px; cursor: pointer; font-family: inherit;">Cerrar Sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}">Ingresar</a>
        @endauth
    </nav>
</header>

<div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px; font-family: 'Montserrat', sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="page-title" style="font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #3a3028; margin: 0;">
            👥 Gestión de Clientes
        </h2>
        <a href="{{ auth()->user()->esAdmin() ? '/admin/dashboard' : '/recepcionista/dashboard' }}" class="btn-volver" style="background-color: #d4a574; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500;">
            ← Volver al Panel
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de Clientes --}}
    <div class="card" style="background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow-x: auto;">
        <h4 style="margin-top: 0; margin-bottom: 20px; color: #6b5c4e; font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; border-bottom: 1px solid #f4eee8; padding-bottom: 10px;">
            Listado de Clientes ({{ $clientes->total() }})
        </h4>

        @if($clientes->count() > 0)
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f8f5f0; border-bottom: 2px solid #e8e0d6;">
                        <th style="padding: 15px; text-align: left; color: #6b5c4e; font-weight: 600; letter-spacing: 0.05em;">NOMBRE</th>
                        <th style="padding: 15px; text-align: left; color: #6b5c4e; font-weight: 600; letter-spacing: 0.05em;">EMAIL</th>
                        <th style="padding: 15px; text-align: left; color: #6b5c4e; font-weight: 600; letter-spacing: 0.05em;">FECHA REGISTRO</th>
                        <th style="padding: 15px; text-align: center; color: #6b5c4e; font-weight: 600; letter-spacing: 0.05em;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr style="border-bottom: 1px solid #f4eee8; hover:background-color: #faf8f5;">
                            <td style="padding: 15px; color: #5a4b41; font-weight: 500;">{{ $cliente->name }}</td>
                            <td style="padding: 15px; color: #5a4b41;">{{ $cliente->email }}</td>
                            <td style="padding: 15px; color: #9a8b7d; font-size: 12px;">{{ $cliente->created_at->format('d/m/Y') }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}" style="color: #d4a574; text-decoration: none; font-weight: 500; margin-right: 15px;">Editar</a>
                                <form method="POST" action="{{ route('admin.clientes.destroy', $cliente->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')" style="background: none; border: none; color: #d9534f; text-decoration: none; font-weight: 500; cursor: pointer;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $clientes->links('vendor.pagination.custom') }}
            </div>
        @else
            <p style="text-align: center; color: #9a8b7d; padding: 40px 0; font-size: 16px;">
                No hay clientes registrados aún.
            </p>
        @endif
    </div>
</div>

</body>
</html>
