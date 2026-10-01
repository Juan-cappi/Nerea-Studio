<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Editar Cliente</title>
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

<div style="max-width: 600px; margin: 0 auto; padding: 40px 20px; font-family: 'Montserrat', sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="page-title" style="font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #3a3028; margin: 0;">
            Editar Cliente
        </h2>
        <a href="{{ route('admin.clientes.index') }}" class="btn-volver" style="background-color: #d4a574; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500;">
            ← Volver
        </a>
    </div>

    {{-- Formulario de edición --}}
    <div class="card" style="background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <form action="{{ route('admin.clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; color: #6b5c4e; letter-spacing: 0.05em;">NOMBRE</label>
                <input type="text" name="name" value="{{ old('name', $cliente->name) }}" class="campo-input-unico" required style="width: 100%; height: 48px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px; background-color: #ffffff; color: #5a4b41; box-sizing: border-box;">
                @error('name')
                    <small style="color: #a94442; font-size: 11px; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; color: #6b5c4e; letter-spacing: 0.05em;">EMAIL</label>
                <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="campo-input-unico" required style="width: 100%; height: 48px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px; background-color: #ffffff; color: #5a4b41; box-sizing: border-box;">
                @error('email')
                    <small style="color: #a94442; font-size: 11px; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-accion" style="width: 100%; height: 48px; background-color: #6b5c4e; color: #ffffff; border: none; border-radius: 25px; font-weight: 500; cursor: pointer; font-size: 14px; margin-bottom: 10px;">
                💾 Guardar Cambios
            </button>

            <a href="{{ route('admin.clientes.index') }}" class="btn-accion" style="width: 100%; height: 48px; background-color: #d4a574; color: #ffffff; border: none; border-radius: 25px; font-weight: 500; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                ← Cancelar
            </a>
        </form>
    </div>
</div>

</body>
</html>
