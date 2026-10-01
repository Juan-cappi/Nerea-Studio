<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea – Iniciar sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
</head>
<body>

<header>
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('img/Logo.jpg')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">        
        </a>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="{{ route('nosotros') }}">Salón</a>

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

<main>
    <div class="hero">
        <img src="{{ asset('Login.jpeg') }}" alt="Nerea Spa">
    </div>

    <div class="form-panel">
        <div class="form-card">
            <div class="form-title">Nerea</div>
            <div class="form-subtitle">Iniciá sesión</div>

            @if(url()->previous() && str_contains(url()->previous(), 'turnos'))
             <div style="background-color: #faf8f5; color: #5a4b41; padding: 12px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #e8e0d6; font-size: 14px; text-align: center;">
                 🔒 Para poder reservar un turno en Nerea Spa, necesitas iniciar sesión o registrarte primero.
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="input-group">
                    <span class="input-icon">✉️</span>
                    <input
                        type="email"
                        name="email"
                        placeholder="Correo electrónico"
                        value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required autofocus autocomplete="username"
                    >
                </div>
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                <div class="input-group has-toggle">
                    <span class="input-icon">🔒</span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Contraseña"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required autocomplete="current-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass('password', this)">Mostrar</button>
                </div>
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                <div class="input-group" style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <input type="checkbox" name="remember" id="remember" style="width: 16px; height: 16px; accent-color: #c5a059; cursor: pointer; margin: 0;">
                    <label for="remember" style="font-size: 13px; color: #5a4b41; cursor: pointer; font-family: 'Montserrat', sans-serif; margin: 0;">Recordarme</label>
                </div>

                <button type="submit" class="btn-submit">Ingresar</button>
            </form>

            <p class="form-footer">
                ¿No tenés cuenta? <a href="{{ route('register') }}">Registrate</a>
            </p>

            <div class="divider"><span>·</span></div>

            <div class="social-btns">
                <a href="#" class="social-btn" title="Google">G</a>
                <a href="#" class="social-btn" title="Facebook">f</a>
                <a href="https://www.instagram.com/nereacolorista/" class="social-btn" title="Instagram">I</a>
            </div>

        </div>
    </div>
</main>

<script>
    function togglePass(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Ocultar';
        } else {
            input.type = 'password';
            btn.textContent = 'Mostrar';
        }
    }
</script>
<x-footer/>
</body>
</html>
