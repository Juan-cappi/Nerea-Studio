<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #fcfbfa; color: #2b2b2b; margin: 0; padding: 20px; }
        .card-mail { max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #eade94; border-radius: 8px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        h1 { color: #5c4033; font-size: 24px; font-weight: 400; text-align: center; margin-bottom: 30px; }
        .detalle-turno { background: #faf8f5; border-left: 4px solid #5c4033; padding: 15px; margin: 20px 0; border-radius: 0 4px 4px 0; }
        .detalle-turno p { margin: 8px 0; font-size: 15px; }
        .btn-calendar { display: block; width: fit-content; margin: 30px auto 10px auto; padding: 12px 25px; background-color: #eade94; color: #2b2b2b; text-decoration: none; font-weight: bold; border-radius: 4px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .footer { text-align: center; font-size: 12px; color: #a0a0a0; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="card-mail">
        <h1>✨ ¡Tu turno está confirmado, {{ $turno->nombre_completo }}! ✨</h1>
        
        <p>Hola, gracias por elegirnos. Te esperamos en el salón con todo listo para consentirte. A continuación te dejamos el resumen de tu reserva:</p>
        
        <div class="detalle-turno">
            <p><strong>📅 Fecha:</strong> {{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</p>
            <p><strong>⏰ Horario:</strong> {{ date('H:i', strtotime($turno->hora)) }} hs</p>
            <p><strong>💇 Servicio ID:</strong> {{ $turno->servicio }}</p>
        </div>

        <!-- 3. [PUNTO 3: GOOGLE CALENDAR] Link dinámico sin configuraciones complejas de APIs -->
        @php
            $fechaCalendar = \Carbon\Carbon::parse($turno->fecha)->format('Ymd');
            $horaInicio = date('Hi', strtotime($turno->hora));
            $horaFin = date('Hi', strtotime($turno->hora . ' +1 hour')); // Estimamos 1 hora de servicio
            $urlCalendar = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=" . urlencode('Turno en Nerea Studio') . "&dates=" . $fechaCalendar . "T" . $horaInicio . "00Z/" . $fechaCalendar . "T" . $horaFin . "00Z&details=" . urlencode('Recordatorio de tu cita en el salón Nerea.') . "&location=" . urlencode('Nerea Studio Salon');
        @endphp

        <a href="{{ $urlCalendar }}" target="_blank" class="btn-calendar">📅 Agendar en mi Google Calendar</a>

        <div class="footer">
            <p>Nerea Studio - Estética y Peluquería</p>
            <p>Si necesitás reprogramar tu turno, comunicate con nosotros a la brevedad.</p>
        </div>
    </div>
</body>
</html>