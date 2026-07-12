<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Recepcionista - Nerea Studio</title>
    @vite(['resources/css/recepcionista.css'])
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
            <a href="{{ route('nosotros') }}">Nosotros</a>

            <!-- 🔐 CONTROL DE ACCESO ADAPTATIVO -->
            @auth
                @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'administrador') || auth()->user()->role === 'administrador')
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                    
                @elseif(auth()->user()->roles->contains('name', 'recepcionista') || auth()->user()->role === 'recepcionista')
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

        
        @if(session('error'))
            <div style="max-width: 600px; margin: 2rem auto 0 auto; background-color: #fdf2f2; border: 1px solid #f5baba; color: #9b2c2c; padding: 15px 20px; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; gap: 10px; z-index: 999; position: relative;">
                <span>🛑</span>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif


<main class="container-recepcionista">
    <div class="recepcionista-header">
        <h1>Panel de Recepcionista</h1>
        <p>Gestiona los turnos y clientes del estudio</p>
    </div>

    <div class="action-buttons">
        <button class="btn-action" onclick="window.location.href='#agenda'">Ver Agenda Completa</button>
        <button class="btn-action" onclick="window.location.href='#clientes'">Gestionar Clientes</button>
    </div>

    <section class="agenda-semanal" id="agenda">
        <h2>Agenda Semanal</h2>

        <div class="agenda-container">
            <div class="calendario-section">
                <h3>Calendario</h3>
                
                <div class="calendario-grid-header">
                    <div class="day-name">Dom</div>
                    <div class="day-name">Lun</div>
                    <div class="day-name">Mar</div>
                    <div class="day-name">Mié</div>
                    <div class="day-name">Jue</div>
                    <div class="day-name">Vie</div>
                    <div class="day-name">Sab</div>
                </div>

                <div class="calendario-grid">
                    @php
                        $primerDia = $fechaCarbon->copy()->startOfMonth();
                        $diasDelMesDelMes = $primerDia->dayOfWeek;
                    @endphp

                    @for ($i = 0; $i < $diasDelMesDelMes; $i++)
                        <div class="day-number disabled"></div>
                    @endfor

                    @foreach($diasDelMes as $diaCalendario)
                        @php
                            $claseDia = 'day-number';
                            if ($diaCalendario['selected']) {
                                $claseDia .= ' selected';
                            }
                            if ($diaCalendario['estado'] === 'partial') {
                                $claseDia .= ' dot-partial';
                            } elseif ($diaCalendario['estado'] === 'full') {
                                $claseDia .= ' dot-full';
                            } else {
                                $claseDia .= ' dot-available';
                            }
                        @endphp
                        <button
                            type="button"
                            class="{{ $claseDia }}"
                            data-day="{{ $diaCalendario['dia'] }}"
                            data-date="{{ $diaCalendario['fecha'] }}"
                            onclick="window.location.href='{{ route('recepcionista.dashboard', ['fecha' => $diaCalendario['fecha']]) }}'"
                        >
                            {{ $diaCalendario['dia'] }}
                        </button>
                    @endforeach
                </div>

                <div class="availability-legend">
                    <div class="legend-item">
                        <div class="legend-dot dot-available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot dot-partial"></div>
                        <span>Parcial</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot dot-full"></div>
                        <span>Completo</span>
                    </div>
                </div>
            </div>

            <div class="horarios-section">
                <h3>Profesionales y Turnos - {{ \Carbon\Carbon::parse($fecha)->translatedFormat('d \d\e F') }}</h3>

                <div class="profesionales-grid">
                    @foreach($agendaProfesionales as $agenda)
                        <div class="profesional-card">
                            <div class="profesional-header">
                                <div class="profesional-avatar">{{ strtoupper(substr($agenda['profesional']->nombre, 0, 1)) }}</div>
                                <div class="profesional-info">
                                    <h4>{{ $agenda['profesional']->nombre }}</h4>
                                    <p>{{ $agenda['profesional']->Especialidad ?? $agenda['profesional']->especialidad ?? 'Sin especialidad' }}</p>
                                </div>
                            </div>
                            <div class="horarios-list">
                                @foreach($agenda['horarios'] as $horario)
                                    <div class="horario-item">
                                        <span class="horario-hora">{{ $horario['hora'] }}</span>
                                        <span class="horario-status {{ $horario['estado'] === 'Ocupado' ? 'status-reservado' : 'status-disponible' }}">{{ $horario['estado'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
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

<script>
    document.querySelectorAll('.day-number[data-day]').forEach(day => {
        day.addEventListener('click', function() {
            document.querySelectorAll('.day-number.selected').forEach(d => d.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
</script>

</body>
</html>
