
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
 <img src="{{ asset('img/logo.png')}}" alt="Logo Nerea" style="height: 100px; width: auto; object-fit: contain; mix-blend-mode: multiply;">    </a>
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="#">Servicios</a>
        <a href="{{ route('turnos') }}">Turnos</a>
        <a href="{{ route('nosotros') }}">Nosotros</a>
        <a href="{{ route('login') }}">Log In</a>
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
            <!-- Calendario -->
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
                    <div class="day-number">1</div>
                    <div class="day-number">2</div>
                    <div class="day-number">3</div>
                    <div class="day-number">4</div>
                    <div class="day-number">5</div>
                    <div class="day-number">6</div>
                    <div class="day-number">7</div>
                    <div class="day-number">8</div>
                    <div class="day-number">9</div>
                    <div class="day-number">10</div>
                    <div class="day-number">11</div>
                    <div class="day-number selected">12</div>
                    <div class="day-number">13</div>
                    <div class="day-number">14</div>
                    <div class="day-number">15</div>
                    <div class="day-number">16</div>
                    <div class="day-number">17</div>
                    <div class="day-number">18</div>
                    <div class="day-number">19</div>
                    <div class="day-number">20</div>
                    <div class="day-number">21</div>
                    <div class="day-number">22</div>
                    <div class="day-number">23</div>
                    <div class="day-number">24</div>
                    <div class="day-number">25</div>
                    <div class="day-number">26</div>
                    <div class="day-number">27</div>
                    <div class="day-number">28</div>
                    <div class="day-number">29</div>
                    <div class="day-number">30</div>
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

</body>
</html>