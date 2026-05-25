<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu Turno - Nerea Studio</title>
    @vite(['resources/css/turnos.css', 'resources/js/turnos.js'])
</head>
<body>

    <header>
        <div class="logo">Nerea</div>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="#">Servicios</a>
            <a href="{{ route('turnos') }}" class="active">Turnos</a>
            <a href="#">Nosotros</a>
            <a href="{{ route('login') }}">Log In</a>
        </nav>
    </header>

    <main class="container-turnos">
        <h1>Reserva tu Turno</h1>
        <p class="subtitulo">Seleccioná el servicio y el turno que mejor se adapte a vos</p>

        <form id="form-turnos">
            <div class="selectores-group">
                <div class="control-select">
                    <label for="servicio">Servicio</label>
                    <select id="servicio">
                        <option value="Corte">Corte - Diseñado a medida</option>
                        <option value="Balayage">Balayage - Sutil y elegante</option>
                        <option value="Alisado">Alisado - Liso y sedoso</option>
                        <option value="Nutrición">Nutrición Capilar</option>
                    </select>
                </div>
                <div class="control-select">
                    <label for="profesional">Profesional</label>
                    <select id="profesional">
                        <option value="Ana">Ana</option>
                        <option value="Clara">Clara</option>
                        <option value="Barbi">Barbi</option>
                    </select>
                </div>
            </div>

            <div class="agenda-block">
                <div class="calendario-dummy">
                    <h3>Seleccionar Fecha (Mayo 2026)</h3>
                    <div class="grid-dias">
                        <div class="dia-nombre">Ma</div>
                        <div class="dia-nombre">Mi</div>
                        <div class="dia-nombre">Ju</div>
                        <div class="dia-nombre">Vi</div>
                        <div class="dia-nombre">Sá</div>
                        
                        <div class="dia-numero inicio-mayo">1</div>
                        <div class="dia-numero">2</div>

                        <div class="dia-numero">5</div>
                        <div class="dia-numero">6</div>
                        <div class="dia-numero">7</div>
                        <div class="dia-numero">8</div>
                        <div class="dia-numero">9</div>

                        <div class="dia-numero">12</div>
                        <div class="dia-numero">13</div>
                        <div class="dia-numero">14</div>
                        <div class="dia-numero">15</div>
                        <div class="dia-numero">16</div>

                        <div class="dia-numero">19</div>
                        <div class="dia-numero">20</div>
                        <div class="dia-numero">21</div>
                        <div class="dia-numero">22</div>
                        <div class="dia-numero">23</div>

                        <div class="dia-numero">26</div>
                        <div class="dia-numero">27</div>
                        <div class="dia-numero">28</div>
                        <div class="dia-numero">29</div>
                        <div class="dia-numero">30</div>
                    </div>
                </div>

                <div class="horarios-dummy">
                    <h3>Horarios Disponibles</h3>
                    <div class="grid-horas">
                        <button type="button" class="hora-btn">09:00</button>
                        <button type="button" class="hora-btn selected">10:00</button>
                        <button type="button" class="hora-btn">11:00</button>
                        <button type="button" class="hora-btn">12:00</button>
                        <button type="button" class="hora-btn">13:00</button>
                        <button type="button" class="hora-btn">15:00</button>
                        <button type="button" class="hora-btn">16:00</button>
                        <button type="button" class="hora-btn">17:00</button>
                        <button type="button" class="hora-btn">18:00</button>
                    </div>
                </div>

                <div class="btn-confirmar-container">
                    <button type="submit" class="btn-confirmar">Confirmar Turno</button>
                </div>
            </div>
        </form>
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
        let diaSeleccionado = "1";
        let horaSeleccionada = "10:00";

        // Selección dinámica de días
        const dias = document.querySelectorAll('.dia-numero');
        dias.forEach(dia => {
            dia.addEventListener('click', () => {
                dias.forEach(d => d.classList.remove('selected'));
                dia.classList.add('selected');
                diaSeleccionado = dia.innerText;
            });
        });

        // Selección dinámica de horas
        const horas = document.querySelectorAll('.hora-btn');
        horas.forEach(hora => {
            hora.addEventListener('click', () => {
                horas.forEach(h => h.classList.remove('selected'));
                hora.classList.add('selected');
                horaSeleccionada = hora.innerText;
            });
        });

        // Enviar y proseguir
        document.getElementById('form-turnos').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const servicio = document.getElementById('servicio').value;
            const profesional = document.getElementById('profesional').value;

            alert(`✨ ¡Turno Procesado! ✨\n\n✂️ Servicio: ${servicio}\n👩‍🦱 Estilista: ${profesional}\n📅 Fecha: ${diaSeleccionado} de Mayo\n⏰ Horario: ${horaSeleccionada} hs.\n\nAl presionar aceptar, proseguirás a la pantalla de Inicio.`);
            
            window.location.href = "{{ route('home') }}";
        });
    </script>

</body>
</html>