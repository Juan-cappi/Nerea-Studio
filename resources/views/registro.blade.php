<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea – Registrate</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
</head>
<body>

<x-header />

<main>
    <div class="hero">
        <img src="{{ asset('Login.jpeg') }}" alt="Nerea Spa">
    </div>

    <div class="form-panel">
        <div class="form-card">
            <div class="form-title">Nerea</div>
            <div class="form-subtitle">Crear cuenta</div>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <!-- Nombre -->
                <div class="input-group">
                    <span class="input-icon">👤</span>
                    <input
                        type="text"
                        name="name"
                        placeholder="Nombre completo"
                        value="{{ old('name') }}"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                        required autofocus autocomplete="name"
                    >
                </div>
                @error('name')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                
                <div class="input-group">
                    <span class="input-icon">✉️</span>
                    <input
                        type="email"
                        name="email"
                        placeholder="Correo electrónico"
                        value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required autocomplete="email"
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
                        required autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass('password', this)">Mostrar</button>
                </div>
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                
                <div class="input-group has-toggle">
                    <span class="input-icon">🔐</span>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="Confirmar contraseña"
                        class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        required autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">Mostrar</button>
                </div>
                @error('password_confirmation')
                    <p class="error-msg">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn-submit">Crear cuenta</button>
            </form>

            <p class="form-footer">
                ¿Ya tenés cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
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
