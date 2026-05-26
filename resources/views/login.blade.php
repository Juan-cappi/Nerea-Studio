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
        <div class="logo-circle"><span>N</span></div>
    <nav>
        </a>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="#">Servicios</a>
        <a href="{{ route('turnos') }}">Turnos</a>
        <a href="#">Nosotros</a>
        <a href="{{ route('login') }}">Log In</a>
    </nav>
</header>

<main>
    <div class="hero">
        <img src="{{ asset('Login.jpg') }}" alt="Nerea Spa">
    </div>

    <div class="form-panel">
        <div class="form-card">
            <div class="form-title">Nerea</div>
            <div class="form-subtitle">Iniciá sesión</div>

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

                <div class="input-group">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold">
                        Recordarme
                    </label>
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
                <a href="#" class="social-btn" title="Apple">⌘</a>
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

</body>
</html>
