<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Editar Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
    <style>
        body { background: #f9f5f0; }
        .container { max-width: 500px; margin: 2rem auto; padding: 0 1rem; }
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            color: #6b5c4e;
            text-align: center;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .input-group {
            margin-bottom: 1.2rem;
        }
        .input-group label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            color: #6b5c4e;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        /* 📐 Cambiá la línea 39 para que incluya al select */
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 0.6rem 1rem;
            box-sizing: border-box; /* ◄ Clave para que el padding no estire el ancho */
            border: 1px solid #e8e0d6; /* El color de borde que venías usando */
            border-radius: 6px;
            background-color: #fff;
            font-family: 'Montserrat', sans-serif;
            color: #5a4b41;
            font-size: 0.9rem;
            outline: none;
            height: 44px; /* Forzamos la misma altura para ambos */
            appearance: none; /* Opcional: quita la flecha nativa si querés personalizarla */
        }
        .error {
            color: #c0392b;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem;
            margin-top: 0.3rem;
        }
        .btn-submit {
            width: 100%;
            background: #6b5c4e;
            color: #fff;
            border: none;
            padding: 0.75rem;
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .btn-volver {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #6b5c4e;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-circle"><span>N</span></div>
    </a>
    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('admin.dashboard') }}">Panel</a>
        <a href="{{ route('profesionales.index') }}">Profesionales</a>
    </nav>
</header>

<div class="container">
    <h1 class="page-title">Editar Profesional</h1>

    <div class="card">
        <form method="POST" action="{{ route('profesionales.update', $profesional->id) }}">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $profesional->nombre) }}" placeholder="Nombre completo">
                @error('nombre') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $profesional->email) }}" placeholder="correo@email.com">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="input-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $profesional->telefono) }}" placeholder="54 11 1234 5678">
                @error('telefono') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="input-group">
                <label>ESPECIALIDAD</label>
                <select name="especialidad_id" class="campo-input-unico" required>
                    <option value="" disabled>Seleccioná una especialidad</option>
                    @foreach($especialidades as $esp)
                        <!-- Comprobamos si el profesional ya tiene vinculada esta especialidad por ID -->
                        <option value="{{ $esp->id }}" {{ $profesional->especialidades->contains($esp->id) ? 'selected' : '' }}>
                            {{ $esp->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Actualizar Profesional</button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al listado</a>
    </div>
</div>

</body>
</html>
