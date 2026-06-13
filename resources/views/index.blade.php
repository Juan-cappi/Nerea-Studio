<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Tu cabello, tu historia</title>
    @vite(['resources/js/app.js'])
</head>
<body>

<header>
    <a href="{{ url('/') }}" class="brand-link">
        <div class="logo-circle"><span>N</span></div>
        <span class="brand-name">NEREA STUDIO</span>
    </a>
    <nav>
        <a href="{{ route('home') }}">INICIO</a>
        <a href="{{ route('servicios') }}">SERVICIOS</a>
        <a href="{{ route('turnos') }}">TURNOS</a>
        <a href="#">NOSOTROS</a>
        <a href="{{ route('login') }}">LOG IN</a>
    </nav>
</header>

<main>
    @if (session('status'))
        <div style="background-color: var(--color-primario); color: var(--color-blanco); padding: 15px; text-align: center; font-weight: bold; margin-bottom: 20px; border-radius: 4px; letter-spacing: 1px; font-size: 14px;">
            {{ session('status') }}
        </div>
    @endif

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
            Más que un turno, buscamos que tu paso por el salón sea una experiencia: un momento para vos, 
            para desconectar, sentirte cómoda y salir renovada.
        </p>
    </section>

    <section class="pilar">
        <h2 class="pilar-title">Nuestros Pilares</h2>
        <div class="pilares">
            <div class="pilar-card">
                <h3>Excelencia Técnica</h3>
                <p>Expertos apasionados por la colorimetría y el corte de precisión.</p>
            </div>
            <div class="pilar-card">
                <h3>Entorno Consciente</h3>
                <p>Un salón diseñado bajo una estética minimalista para brindarte calma y exclusividad.</p>
            </div>
            <div class="pilar-card">
                <h3>Cuidado Real</h3>
                <p>Utilizamos productos de alta gama que garantizan resultados visibles sin comprometer la salud.</p>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="footer-col">
        <h4 class="footer-brand">Nerea Studio</h4>
        <p class="footer-text-muted">Belleza y experiencia personalizada.</p>
        <p class="footer-copyright">&copy; 2026 Nerea Studio</p>
    </div>
    <div class="footer-col footer-right">
        <h4>Contacto</h4>
        <p class="footer-info">Dirección del salón, Buenos Aires</p>
        <p class="footer-info">+54 11 1234 5678</p>
        <p class="footer-info">nerea@email.com</p>
    </div>
</footer>

</body>
</html>