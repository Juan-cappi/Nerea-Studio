<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Panel Servicios</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/css/admin.css'])
</head>
<body style="display: block; background-color: #f8f5f0; margin: 0; padding: 0;">

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
    <div style="max-width: 600px; margin: 0 auto; padding: 0 20px; font-family: 'Montserrat', sans-serif;">
        
        <h2 class="page-title" style="text-align: center; margin-bottom: 1.5rem; font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #3a3028;">
            Gestión de Servicios
        </h2>

        <div class="card" style="background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;">
            <h4 style="margin-top: 0; margin-bottom: 15px; color: #6b5c4e; font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; border-bottom: 1px solid #f4eee8; padding-bottom: 10px;">
                ✂️ Agregar Nuevo Servicio
            </h4>

            @if(session('status'))
                <div style="background-color: #faf8f5; color: #5a4b41; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e8e0d6; font-size: 14px; text-align: center;">
                    ✨ {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #fdf2f2; color: #9b3a3a; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f0d6d6; font-size: 14px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.servicios.store') }}" method="POST">
                @csrf
                
                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; color: #6b5c4e;">NOMBRE DEL SERVICIO</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="campo-input-unico" placeholder="Ej: Balayage, Alisado, Corte..." required style="width: 100%; height: 48px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px;">
                </div>

                <div class="input-group" style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; color: #6b5c4e;">¿QUÉ ESPECIALIDAD LO REALIZA?</label>
                    <select name="especialidad_id" class="campo-input-unico" required style="width: 100%; height: 48px; padding: 10px; border: 1px solid #e8e0d6; border-radius: 6px; background: #fff;">
                        <option value="" disabled selected>Elegí una especialidad...</option>
                        @foreach($especialidades as $esp)
                            <option value="{{ $esp->id }}" {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>{{ $esp->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-accion" style="width: 100%; height: 48px; background-color: #6b5c4e; color: #ffffff; border: none; border-radius: 25px; font-weight: 500; cursor: pointer;">
                    + Guardar Servicio
                </button>
            </form>
        </div>

        <div class="card" style="background: #ffffff; border-radius: 16px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="text-align: left; color: #9c8470; font-size: 12px; border-bottom: 1px solid #e8e0d6;">
                        <th style="padding: 10px 5px;">Servicio</th>
                        <th style="padding: 10px 5px;">Especialidad Mapeada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $ser)
                        <tr style="border-bottom: 1px solid #f4eee8; color: #5a4b41;">
                            <td style="padding: 12px 5px; font-weight: 500;">{{ $ser->nombre }}</td>
                            <td style="padding: 12px 5px;">
                                <span style="background-color: #faf8f5; color: #6b5c4e; padding: 4px 10px; border-radius: 12px; font-size: 12px; border: 1px solid #e8e0d6;">
                                    {{ $ser->specialty->nombre ?? 'Sin especialidad' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding: 15px; text-align: center; color: #b5a496; font-style: italic;">No hay servicios cargados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $servicios->links('vendor.pagination.nerea') }}
        </div>

        <div style="text-align: center; margin-bottom: 3rem;">
            <a href="{{ url('/admin/dashboard') }}" style="color: #6b5c4e; text-decoration: none; font-size: 13px; font-weight: 500;">
                ← Volver al Panel de Administración
            </a>
        </div>
    </div>
</body>
</html>