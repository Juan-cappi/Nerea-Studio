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
            <a href="#">Nosotros</a>

            @auth
                @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'administrador'))
                    <a href="/admin/dashboard" class="btn-perfil-shortcut">Panel Admin</a>
                    
                @elseif(auth()->user()->roles->contains('name', 'recepcionista'))
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
                    <div class="day-number disabled"></div>
                    <div class="day-number disabled"></div>
                    <div class="day-number disabled"></div>
                    <div class="day-number disabled"></div>
                    <div class="day-number disabled"></div>
                    <div class="day-number" data-day="1">1</div>
                    <div class="day-number" data-day="2">2</div>
                    <div class="day-number" data-day="3">3</div>
                    <div class="day-number" data-day="4">4</div>
                    <div class="day-number" data-day="5">5</div>
                    <div class="day-number" data-day="6">6</div>
                    <div class="day-number" data-day="7">7</div>
                    <div class="day-number" data-day="8">8</div>
                    <div class="day-number" data-day="9">9</div>
                    <div class="day-number" data-day="10">10</div>
                    <div class="day-number" data-day="11">11</div>
                    <div class="day-number selected" data-day="12">12</div>
                    <div class="day-number" data-day="13">13</div>
                    <div class="day-number" data-day="14">14</div>
                    <div class="day-number" data-day="15">15</div>
                    <div class="day-number" data-day="16">16</div>
                    <div class="day-number" data-day="17">17</div>
                    <div class="day-number" data-day="18">18</div>
                    <div class="day-number" data-day="19">19</div>
                    <div class="day-number" data-day="20">20</div>
                    <div class="day-number" data-day="21">21</div>
                    <div class="day-number" data-day="22">22</div>
                    <div class="day-number" data-day="23">23</div>
                    <div class="day-number" data-day="24">24</div>
                    <div class="day-number" data-day="25">25</div>
                    <div class="day-number" data-day="26">26</div>
                    <div class="day-number" data-day="27">27</div>
                    <div class="day-number" data-day="28">28</div>
                    <div class="day-number" data-day="29">29</div>
                    <div class="day-number" data-day="30">30</div>
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
                <h3>Profesionales y Turnos - 12 de Junio</h3>

                <div class="profesionales-grid">
                    <div class="profesional-card">
                        <div class="profesional-header">
                            <div class="profesional-avatar">A</div>
                            <div class="profesional-info">
                                <h4>Ana</h4>
                                <p>Corte y mechas</p>
                            </div>
                        </div>
                        <div class="horarios-list">
                            <div class="horario-item">
                                <span class="horario-hora">09:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">09:30</span>
                                <span class="horario-status status-reservado">Reservado</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:00</span>
                                <span class="horario-status status-reservado">Reservado</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:30</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">14:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">15:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                        </div>
                    </div>

                    <div class="profesional-card">
                        <div class="profesional-header">
                            <div class="profesional-avatar">C</div>
                            <div class="profesional-info">
                                <h4>Clara</h4>
                                <p>Corte y mechas</p>
                            </div>
                        </div>
                        <div class="horarios-list">
                            <div class="horario-item">
                                <span class="horario-hora">09:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">09:30</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:30</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">14:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">15:00</span>
                                <span class="horario-status status-reservado">Reservado</span>
                            </div>
                        </div>
                    </div>

                    <div class="profesional-card">
                        <div class="profesional-header">
                            <div class="profesional-avatar">B</div>
                            <div class="profesional-info">
                                <h4>Barbi</h4>
                                <p>Corte y mechas</p>
                            </div>
                        </div>
                        <div class="horarios-list">
                            <div class="horario-item">
                                <span class="horario-hora">09:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">09:30</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:00</span>
                                <span class="horario-status status-reservado">Reservado</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">10:30</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">14:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-hora">15:00</span>
                                <span class="horario-status status-disponible">Disponible</span>
                            </div>
                        </div>
                    </div>
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
    // Hacer el calendario interactivo
    document.querySelectorAll('.day-number[data-day]').forEach(day => {
        day.addEventListener('click', function() {
            // Remover la clase selected de todos los días
            document.querySelectorAll('.day-number.selected').forEach(d => d.classList.remove('selected'));
            
            // Añadir la clase selected al día clickeado
            this.classList.add('selected');
            
            // Obtener el número del día
            const dayNumber = this.getAttribute('data-day');
            
            // Actualizar el título de "Profesionales y Turnos"
            const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const horarioTitle = document.querySelector('.horarios-section h3');
            if (horarioTitle) {
                horarioTitle.textContent = `Profesionales y Turnos - ${dayNumber} de ${monthNames[5]}`;
            }
        });
    });
</script>

</body>
</html>
