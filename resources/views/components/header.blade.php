<header style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background-color: #fff; border-bottom: 1px solid #e6dec1;">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('img/Logo.jpg') }}" alt="Logo Nerea" style="height: 80px; width: auto; object-fit: contain; mix-blend-mode: multiply;">
    </a>
    
    <nav style="display: flex; align-items: center; gap: 30px;">
        <a href="{{ route('home') }}" style="text-decoration: none; color: #2a2521; font-weight: 500; text-transform: uppercase; font-size: 14px;">Inicio</a>
        <a href="{{ route('servicios') }}" style="text-decoration: none; color: #2a2521; font-weight: 500; text-transform: uppercase; font-size: 14px;">Servicios</a>
        <a href="{{ route('turnos') }}" style="text-decoration: none; color: #2a2521; font-weight: 500; text-transform: uppercase; font-size: 14px;">Turnos</a>
        <a href="{{ route('nosotros') }}" style="text-decoration: none; color: #2a2521; font-weight: 500; text-transform: uppercase; font-size: 14px;">Salón</a>

        @auth
            @if(auth()->user()->esAdmin())
                <a href="/admin/dashboard" class="btn-perfil-shortcut" style="text-decoration: none; color: #8C6243; font-weight: bold; text-transform: uppercase; font-size: 14px;">Panel Admin</a>
            @elseif(auth()->user()->esRecepcionista())
                <a href="/recepcionista/dashboard" class="btn-perfil-shortcut" style="text-decoration: none; color: #8C6243; font-weight: bold; text-transform: uppercase; font-size: 14px;">Panel Recepción</a>
            @else
                <a href="{{ route('cliente.perfil') }}" class="btn-perfil-shortcut" style="text-decoration: none; color: #8C6243; font-weight: bold; text-transform: uppercase; font-size: 14px;">Mi Perfil</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" class="btn-logout" style="background: none; border: none; color: #2a2521; text-transform: uppercase; letter-spacing: 1px; font-size: 14px; cursor: pointer; font-family: inherit;">Cerrar Sesión</button>
            </form>
        @endauth
        {{-- Ocultamos el @else con el link de "Ingresar" público para que los clientes comunes no lo vean --}}
    </nav>
</header>