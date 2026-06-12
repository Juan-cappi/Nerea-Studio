<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Nerea Studio</title>
    @vite(['resources/css/app.css'])
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
        <a href="{{ route('login') }}">Log In</a>
    </nav>
</header>

<main>
    @include('components.services')
</main>

<footer>
    <div class="footer-col">
        <h4>Nerea Studio</h4>
        <p>Belleza y experiencia personalizada.</p>
        <p style="margin-top: 10px;">&copy; 2026 Nerea Studio</p>
    </div>
    <div class="footer-col">
        <h4>Contacto</h4>
        <p>Dirección del salón</p>
        <p>+54 11 1234 5678</p>
        <p>nerea@email.com</p>
    </div>
</footer>
</body>
</html>
