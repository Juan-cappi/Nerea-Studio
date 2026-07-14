<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Editar Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
    <style>
        body { background: #f9f5f0; }
        .container { max-width: 500px; margin: 2rem auto; padding: 0 1rem; }
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            color: #6b5c4e;
            text-align: center;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .input-group {
            margin-bottom: 1.2rem;
        }
        .input-group label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            color: #6b5c4e;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        .input-group input {
            width: 100%;
            padding: 0.6rem 1rem;
            border: 1px solid #e8ddd4;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            color: #6b5c4e;
            background: #f9f5f0;
            box-sizing: border-box;
        }
        .error {
            color: #c0392b;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem;
            margin-top: 0.3rem;
        }
        .btn-submit {
            width: 100%;
            background: #6b5c4e;
            color: #fff;
            border: none;
            padding: 0.75rem;
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .btn-volver {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #6b5c4e;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <a href="{{ url('/') }}" class="logo">
 <img src="{{ asset('img/logo.png')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">    </a>
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

<div class="container">
    <h1 class="page-title">Editar Profesional</h1>

    <div class="card">
        <form method="POST" action="{{ route('profesionales.update', $profesional->id) }}">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $profesional->nombre) }}" placeholder="Nombre completo">
                @error('nombre') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $profesional->email) }}" placeholder="correo@email.com">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="input-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $profesional->telefono) }}" placeholder="54 11 1234 5678">
                @error('telefono') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-submit">Actualizar Profesional</button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al listado</a>
    </div>
</div>

</body>
</html>
