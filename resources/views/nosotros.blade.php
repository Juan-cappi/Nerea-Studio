<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Nerea Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    
    <style>
        
        body {
            background-color: #f8f5f0;
            color: #5a4b41;
            margin: 0;
        }

        .nosotros-hero {
            max-width: 1200px;
            margin: 4rem auto 2rem auto;
            text-align: center;
            padding: 0 20px;
        }

        .nosotros-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            color: #3a3028;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .nosotros-hero p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
            color: #6b5c4e;
        }

       
        .seccion-bloque {
            max-width: 1200px;
            margin: 5rem auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            padding: 0 20px;
        }

        .bloque-texto h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            color: #3a3028;
            margin-top: 0;
            margin-bottom: 1.5rem;
        }

        .bloque-texto p {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            line-height: 1.7;
            color: #6b5c4e;
            margin-bottom: 1.5rem;
        }

        .bloque-imagen {
            width: 100%;
            height: 450px;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.02);
            border: 1px solid #f4eee8;
        }

        .bloque-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

       
        .valores-contenedor {
            background-color: #faf8f5;
            border-top: 1px solid #e8e0d6;
            border-bottom: 1px solid #e8e0d6;
            padding: 5px 0;
            margin-top: 6rem;
        }

        .valores-grid {
            max-width: 1200px;
            margin: 4rem auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            padding: 0 20px;
        }

        .valor-card {
            text-align: center;
            padding: 20px;
        }

        .valor-card h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            color: #3a3028;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .valor-card p {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            line-height: 1.6;
            color: #6b5c4e;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .seccion-bloque {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .seccion-bloque:nth-child(even) {
                direction: ltr;
            }
            .valores-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .bloque-imagen {
                height: 300px;
            }
        }
    </style>
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

    <main style="padding-top: 40px;">
        
        
        <section class="nosotros-hero">
            <h1>Nuestra Esencia</h1>
            <p>Nerea Studio no es solo un salón de belleza; es un refugio diseñado para pausar el ritmo del día a día, conectar con vos misma y redescubrir el potencial de tu cabello a través de un diagnóstico honesto y artesanal.</p>
        </section>

      
        <section class="seccion-bloque">
            <div class="bloque-texto">
                <h2>El Comienzo de un Refugio</h2>
                <p>Nerea Studio nació en el corazón de Buenos Aires con un propósito claro: transformar la clásica e impersonal visita a la peluquería en una experiencia sensorial de calma, disfrute y respeto absoluto por la salud de tu fibra capilar.</p>
                <p>Entendemos que cada melena cuenta una historia única. Por eso, nos alejamos de las soluciones masivas y los tratamientos agresivos para enfocarnos en técnicas personalizadas que resalten tu belleza natural de forma orgánica y sofisticada.</p>
            </div>
            <div class="bloque-imagen">
                
                <img src="{{ asset('img/salon.jpeg') }}" alt="Nerea Studio Salon">
            </div>
        </section>

       
        <section class="valores-contenedor">
            <div class="valores-grid">
                
                <div class="valor-card">
                    <h3>Salud Consciente</h3>
                    <p>Priorizamos la integridad de tu cabello. Cada producto y coloración global es seleccionado minuciosamente para nutrir, proteger y dar brillo sin comprometer la estructura capilar.</p>
                </div>

                <div class="valor-card">
                    <h3>Atención de Autor</h3>
                    <p>No trabajamos apurados. Te asignamos un bloque de tiempo exclusivo con tu estilista para escucharte, diagnosticar tu cuero cabelludo y diseñar un look a tu medida.</p>
                </div>

                <div class="valor-card">
                    <h3>Ritual de Pausa</h3>
                    <p>Nuestros lavados premium con masajes capilares neurosedantes y música suave están pensados para que tu visita sea un verdadero momento de bienestar y desconexión total.</p>
                </div>

            </div>
        </section>

       
        <section class="seccion-bloque" style="margin-bottom: 8rem;">
      
            <div class="bloque-imagen" style="grid-column: 1;">
               
                <img src="{{ asset('img/servicios/mechas balayage.jpeg') }}" alt="Profesionales trabajando">
            </div>
            <div class="bloque-texto" style="grid-column: 2;">
                <h2>Manos Profesionales</h2>
                <p>Detrás de Nerea Studio hay un equipo apasionado de coloristas, estilistas y técnicos en constante formación internacional. Nos apasiona dominar las últimas vanguardias mundiales, desde la sutileza de un Balayage artesanal hasta la precisión de tratamientos moleculares avanzados.</p>
                <p>Pero por sobre todo, nos define la calidez humana. Nos encanta recibirte, compartir un café o un té relajante, y acompañarte en el proceso de cuidar y lucir el cabello que siempre soñaste.</p>
            </div>
        </section>

    </main>
    
<x-footer/>
</body>
</html>