<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Tu cabello, tu historia</title>
    
    <!-- Fuentes elegantes del Login -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/home.css', 'resources/js/app.js'])
</head>
<body>

    <header>
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-circle">
                <span>N</span>
            </div>
        </a>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('servicios') }}">Servicios</a>
            <a href="{{ route('turnos') }}">Turnos</a>
            <a href="#">Nosotros</a>

            @auth
                @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'administrador') || auth()->user()->role === 'administrador')
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                @elseif(auth()->user()->roles->contains('name', 'recepcionista') || auth()->user()->role === 'recepcionista')
                    <a href="/recepcionista/dashboard" class="btn-perfil-shortcut">Panel Recepción</a>
                @else
                    <a href="{{ route('cliente.perfil') }}" class="btn-perfil-shortcut">Mi Perfil</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Ingresar</a>
            @endauth
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Nerea</h1>
                <p>TU CABELLO, TU HISTORIA</p>
                <a href="{{ route('turnos') }}" class="btn-reserva">Reserva tu turno</a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('Login.jpg') }}" alt="Nerea Estudio" class="hero-img-src">
            </div>
        </section>

        <section class="pilar">
            <h2 class="pilar-title">Nuestros Servicios</h2>
            <div class="pilares">
                <div class="pilar-card">
                    <div class="pilar-img-placeholder" style="background-image: url('{{ asset('services/corte.jpg') }}');"></div>
                    <h3>Corte de Precisión</h3>
                    <p>Estilo y personalización para cada tipo de cabello.</p>
                </div>
                <div class="pilar-card">
                    <div class="pilar-img-placeholder" style="background-image: url('{{ asset('services/balayage.jpg') }}');"></div>
                    <h3>Colorimetría Avanzada</h3>
                    <p>Técnicas de Balayage, reflejos y cuidado consciente de tu fibra.</p>
                </div>
                <div class="pilar-card">
                    <div class="pilar-img-placeholder" style="background-image: url('{{ asset('services/nutricion.jpg') }}');"></div>
                    <h3>Tratamientos & Nutrición</h3>
                    <p>Olaplex y nutrición profunda para recuperar el brillo natural.</p>
                </div>
            </div>
        </section>
        
        <section class="esencia">
            <h2>Nuestra Esencia</h2>
            <p class="esencia-p">
                En nuestro salón creemos que cada cabello es único, y por eso cada atención también lo es. 
                Trabajamos de manera personalizada, escuchando, observando y entendiendo las necesidades de cada cliente 
                para lograr resultados reales, cuidados y a medida. 
                Elegimos trabajar con productos de primera línea como L’Oréal, Olaplex, Schwarzkopf y Moroccanoil. 
            </p>
        </section>
    </main>

    <footer>
        <div class="footer-col">
            <h4 class="footer-brand">Nerea Studio</h4>
            <p class="footer-text-muted">&copy; 2026 Nerea Studio</p>
        </div>
        <div class="footer-col footer-right">
            <h4>Contacto</h4>
            <p class="footer-info">Buenos Aires, Argentina</p>
        </div>
    </footer>

</body>
</html>