

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu Turno - Nerea Studio</title>
    @vite(['resources/css/turnos.css', 'resources/js/turnos.js'])
</head>
<body>

 <header>
        <a href="{{ url('/') }}" class="logo">
        <div class="logo-circle"><span>N</span></div>
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('servicios') }}">Servicios</a>
        <a href="{{ route('turnos') }}">Turnos</a>
        <a href="#">Nosotros</a>
        <a href="{{ route('login') }}">Log In</a>
    </nav>

</header>
    <main class="container-turnos">
        <h1>Reserva tu Turno</h1>
        <p class="subtitulo">Seleccioná el servicio y el turno que mejor se adapte a vos</p>

        @livewire('turnos')

        @livewireStyles
        @livewireScripts
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