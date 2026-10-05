<header style="display: flex; justify-content: space-between; align-items: center; padding: 25px 50px; background-color: #fff; border-bottom: 1px solid #f0e9df; font-family: 'Montserrat', sans-serif;">
    
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center;">
    <img src="{{ asset('img/Logo.jpg') }}" alt="Logo Nerea" style="height: 55px; width: 55px; border-radius: 50%; object-fit: cover; border: 1px solid #e6dec1;">        
</a>
    
    <!-- Menú Minimalista -->
    <nav style="display: flex; align-items: center; gap: 35px;">
        <a href="{{ route('home') }}" class="nav-link-nerea">Inicio</a>
        <a href="{{ route('servicios') }}" class="nav-link-nerea">Servicios</a>
        <a href="{{ route('turnos') }}" class="nav-link-nerea">Turnos</a>
        <a href="{{ route('nosotros') }}" class="nav-link-nerea">Salón</a>

        @auth
            @if(auth()->user()->esAdmin())
                <a href="/admin/dashboard" class="nav-link-nerea admin-link">Panel Admin</a>
            @elseif(auth()->user()->esRecepcionista())
                <a href="/recepcionista/dashboard" class="nav-link-nerea admin-link">Panel Recepción</a>
            @else
                <a href="{{ route('cliente.perfil') }}" class="nav-link-nerea admin-link">Mi Perfil</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" class="btn-logout-nerea">Cerrar Sesión</button>
            </form>
        @endauth
    </nav>
</header>

<style>
    /* Estilos minimalistas y limpios para el menú */
    .nav-link-nerea {
        text-decoration: none;
        color: #2a2521;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: color 0.3s ease;
        position: relative;
    }
    .nav-link-nerea::after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: -4px;
        left: 0;
        background-color: #8C6243; /* Color primario de tu paleta */
        transition: width 0.3s ease;
    }
    .nav-link-nerea:hover {
        color: #8C6243;
    }
    .nav-link-nerea:hover::after {
        width: 100%;
    }
    .admin-link {
        color: #8C6243 !important;
        font-weight: 600;
    }
    .btn-logout-nerea {
        background: none;
        border: none;
        color: #6a6156;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        cursor: pointer;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        padding: 0;
        transition: color 0.3s ease;
    }
    .btn-logout-nerea:hover {
        color: #2a2521;
    }
</style>