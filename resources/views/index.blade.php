<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Tu cabello, tu historia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <section class="hero">
            <div class="hero-text">
                <h1>Nerea</h1>
                <p>TU CABELLO, TU HISTORIA</p>
                <a href="{{ route('turnos') }}" class="btn-reserva">Reserva tu turno</a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('Login.jpg') }}" alt="Nerea Estudio">
            </div>
        </section>
        <section class="esencia">
            <h2>Nuestra Esencia</h2>
                <p class="esencia-p">EN NUESTRO SALÓN CREEMOS QUE CADA
                                                    CABELLO ES ÚNICO, Y POR ESO CADA ATENCIÓN
                                                    TAMBIÉN LO ES. TRABAJAMOS DE MANERA
                                                    PERSONALIZADA, ESCUCHANDO, OBSERVANDO
                                                    Y ENTENDIENDO LAS NECESIDADES DE CADA
                                                    CLIENTE PARA LOGRAR RESULTADOS REALES,
                                                    CUIDADOS Y A MEDIDA.
                                                    ELEGIMOS TRABAJAR CON PRODUCTOS DE
                                                    PRIMERA LÍNEA COMO L’ORÉAL, OLAPLEX,
                                                    SCHWARZKOPF Y MOROCCANOIL, ADAPTANDO
                                                    CADA SERVICIO SEGÚN EL ESTADO Y OBJETIVO
                                                    DE CADA CABELLO. LA CALIDAD NO ES UN
                                                    DETALLE, ES LA BASE DE TODO LO QUE
                                                    HACEMOS.
                                                    MÁS QUE UN TURNO, BUSCAMOS QUE TU PASO
                                                    POR EL SALÓN SEA UNA EXPERIENCIA: UN
                                                    MOMENTO PARA VOS, PARA DESCONECTAR,
                                                    SENTIRTE CÓMODA Y SALIR RENOVADA.
                                                    CUIDAMOS CADA DETALLE, DESDE EL
                                                    DIAGNÓSTICO HASTA EL RESULTADO FINAL, PARA
                                                    QUE TE LLEVES NO SOLO UN CAMBIO, SINO
                                                    TAMBIÉN UNA SENSACIÓN..</p>
        </section>
            <section class="pilar">
            <h2>Nuestros Pilares</h2>
            <div class="pilares">
                <div class="pilar-card1">
                    <h3>Excelencia Técnica</h3>
                    <p>Expertos apasionados por la colorimetría y el corte de precisión.</p>
                </div>
                <div class="pilar-card2">
                    <h3>Entorno Consciente</h3>
                    <p>Un salón diseñado bajo una estética minimalista para brindarte calma y exclusividad.</p>
                </div>
                
                <div class="pilar-card3">
                    <h3>Cuidado Real</h3>
                    <p>Utilizamos productos de alta gama que garantizan resultados visibles sin comprometer la salud de tu cabello.</p>
                </div>
            </div>
        </section>
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