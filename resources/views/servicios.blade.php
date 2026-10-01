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
        <img src="{{ asset('img/Logo.jpg')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">
    </a>
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

                <!-- Botón de Cerrar Sesión -->
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
    @include('components.services')
</main>

<style>
    /* =========================================
       ✨ FOOTER PREMIUM CON CONTACTOS ✨
       ========================================= */
    .footer-premium {
        background-color: #1e1a17; /* Tono súper oscuro y elegante */
        color: #fbf9f6;
        padding: 60px 8%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 40px;
        border-top: 1px solid #3a332d;
    }

    .footer-brand {
        max-width: 350px;
    }

    .footer-brand h4 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: #c5a059; /* El dorado de tu web */
        margin: 0 0 10px 0;
        font-weight: 400;
        letter-spacing: 1px;
    }

    .footer-brand p {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        color: #a39b93;
        margin: 0 0 5px 0;
        line-height: 1.6;
    }

    .footer-contact h4 {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #c5a059;
        margin: 0 0 25px 0;
        font-weight: 600;
    }

    .contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .contact-link {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fbf9f6;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    /* Efecto de desplazamiento lateral al pasar el mouse */
    .contact-link:hover {
        color: #c5a059;
        transform: translateX(8px); 
    }

    .contact-icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .footer-premium {
            flex-direction: column;
            padding: 50px 5%;
        }
    }
</style>

<x-footer/>
</body>
</html>
