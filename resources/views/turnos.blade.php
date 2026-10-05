<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea Studio - Contacto y Turnos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/turnos.css'])

    <style>
        .card-reserva {
            padding-bottom: 40px !important;
            margin-bottom: 20px !important;
            background: #fbf8f3;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #e6dec1;
        }
        .split-screen-container {
            min-height: 100vh;
            height: auto !important;
            background-color: #f4eee6;
        }
    </style>
</head>
<body>

<x-header />

    <main class="split-screen-container">
        <div class="lado-imagen-salon">
            <img src="{{ asset('img/spa-turnos.jpeg') }}" alt="Nerea Spa" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>

        <div class="lado-formulario-turno">
            <div class="card-reserva" style="padding: 30px;">
                <h2>Solicitar Turno</h2>

                <form action="{{ route('turnos.store') }}" method="POST">
                    @csrf
                 
                    @if ($errors->any())
                        <div class="alert-errores-spa" style="background-color: #fce8e6; color: #a54040; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f7d4d1; font-size: 14px; font-weight: 500;">
                            @foreach ($errors->all() as $error)
                               <p style="margin: 0;">⚠️ {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                            ✨ {{ session('success') }}
                        </div>
                    @endif

                    <div class="input-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">NOMBRE</label>
                        <input type="text" name="nombre" class="campo-input-unico" placeholder="Tu Nombre" 
                            value="{{ auth()->check() ? auth()->user()->name : old('nombre') }}" required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">APELLIDO</label>
                        <input type="text" name="apellido" class="campo-input-unico" placeholder="Tu Apellido" 
                            value="{{ old('apellido') }}" required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">CORREO ELECTRÓNICO</label>
                        <input type="email" name="correo" class="campo-input-unico" placeholder="Tu Correo" 
                            value="{{ auth()->check() ? auth()->user()->email : old('correo') }}" required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">TELÉFONO</label>
                        <input type="text" name="telefono" class="campo-input-unico" placeholder="Tu Teléfono o Celular" 
                            value="{{ old('telefono') }}" required style="border-radius: 4px;">
                    </div>

                    <div class="input-group" style="margin-top: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #2a2521;">SERVICIO DE INTERÉS</label>
                        <select name="servicio_id" id="servicio_select" class="campo-input-unico" required style="border-radius: 4px;">
                            <option value="" disabled selected>Seleccione un servicio</option>
                            @foreach($servicios as $ser)
                                <option value="{{ $ser->id }}">
                                    {{ $ser->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="aviso-pago-seguro" style="background-color: #fcf8f2; border-left: 4px solid #c5a059; padding: 15px; border-radius: 6px; margin: 20px 0; text-align: left;">
                        <p style="margin: 0 0 5px 0; font-weight: 600; color: #2a2521; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                            ✨ Solicitud Directa
                        </p>
                        <p style="margin: 0; color: #6a6156; font-size: 13px; line-height: 1.4;">
                            Envianos tus datos y el servicio que te interesa. Nos pondremos en contacto a la brevedad para coordinar tu día y horario.
                        </p>
                    </div>

                    <button type="button" class="btn-confirmar" onclick="abrirConfirmacion()" style="width: 100%; margin-top: 10px;">
                        Enviar Solicitud
                    </button>
                </form>
            </div>
        </div>
    </main>

    <div id="modal_confirmacion_turno" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; justify-content: center; align-items: center; backdrop-filter: blur(3px);">
        <div style="background: white; padding: 30px; border-radius: 8px; max-width: 420px; width: 90%; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="font-size: 40px; margin-bottom: 15px;">📩</div>
            <h3 style="margin: 0 0 10px 0; color: #2a2521; font-size: 22px; font-weight: 600;">¿Enviar Solicitud?</h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 25px; line-height: 1.5; text-align: left;">
                Estás por enviar tus datos de contacto a <strong>Nerea Colorista - Peluqueria Studio</strong> para coordinar tu turno. Nos comunicaremos con vos a la brevedad.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="cerrarConfirmacion()" style="background: #f0f0f0; color: #444; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px; flex: 1;">Revisar</button>
                <button type="button" onclick="enviarFormularioTurno()" style="background: #2a2521; color: white; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px; flex: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">Enviar</button>
            </div>
        </div>
    </div>
<x-footer/>
</body>
</html>

<script>
    function abrirConfirmacion() {
        const form = document.querySelector('.card-reserva form');
        if (!form.checkValidity()) {
            form.reportValidity(); 
            return;
        }
        document.getElementById('modal_confirmacion_turno').style.display = 'flex';
    }

    function cerrarConfirmacion() {
        document.getElementById('modal_confirmacion_turno').style.display = 'none';
    }

    function enviarFormularioTurno() {
        // 1. Capturar los valores
        const nombre = document.querySelector('input[name="nombre"]').value;
        const apellido = document.querySelector('input[name="apellido"]').value;
        const correo = document.querySelector('input[name="correo"]').value;
        const telefono = document.querySelector('input[name="telefono"]').value;
        
        const servicioSelect = document.getElementById('servicio_select');
        const servicioTexto = servicioSelect.options[servicioSelect.selectedIndex].text;

        // 2. Número de WhatsApp con formato correcto (Ejemplo para Argentina: 54 + 9 + área + número sin 0 ni 15)
        const numeroWhatsApp = "5491166781890"; // <--- CAMBIÁ ESTO POR TU NÚMERO DE PRUEBA

        // 3. Armar el mensaje
        let mensaje = `¡Hola Nerea! 👋 Quiero solicitar un turno desde la web:%0A%0A`;
        mensaje += `👤 *Nombre:* ${nombre} ${apellido}%0A`;
        mensaje += `📧 *Correo:* ${correo}%0A`;
        mensaje += `📱 *Teléfono:* ${telefono}%0A`;
        mensaje += `✨ *Servicio de interés:* ${servicioTexto}%0A%0A`;
        mensaje += `Quedo a la espera para coordinar el día y horario. ¡Gracias!`;

        const urlWhatsApp = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${mensaje}`;

        // 4. Cerrar modal de confirmación
        cerrarConfirmacion();

        // 5. Mostrar un cartelito lindo de éxito en la pantalla antes de abrir WhatsApp
        const cardReserva = document.querySelector('.card-reserva');
        
        // Creamos el div del mensaje de éxito
        const alertaExito = document.createElement('div');
        alertaExito.style.backgroundColor = '#d4edda';
        alertaExito.style.color = '#155724';
        alertaExito.style.padding = '15px';
        alertaExito.style.borderRadius = '8px';
        alertaExito.style.marginBottom = '20px';
        alertaExito.style.fontSize = '14px';
        alertaExito.style.fontWeight = '600';
        alertaExito.style.textAlign = 'center';
        alertaExito.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
        alertaExito.innerHTML = '✨ ¡Solicitud generada con éxito! Abriendo WhatsApp...';

        // Lo insertamos arriba del formulario
        const formElement = cardReserva.querySelector('form');
        cardReserva.insertBefore(alertaExito, formElement);

        // 6. Abrir WhatsApp en otra pestaña tras un breve respiro para que el usuario alcance a leer
        setTimeout(() => {
            window.open(urlWhatsApp, '_blank');
        }, 1000);
    }
</script>