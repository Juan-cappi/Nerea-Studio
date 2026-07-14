<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerea | Editar Especialidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/registro.css', 'resources/css/admin.css'])
</head>
<body style="background: #f8f5f0; margin: 0; padding: 0; font-family: 'Montserrat', sans-serif;">
    <div style="max-width: 580px; margin: 2rem auto; padding: 0 20px;">
        <div style="background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <h2 style="margin-top: 0; margin-bottom: 1.5rem; font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #3a3028; text-align: center;">Editar Especialidad</h2>

            @if($errors->any())
                <div style="background-color: #fef3f3; color: #9b3a3a; padding: 14px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #f4d7d7;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.especialidades.update', $especialidad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; color: #6b5c4e; letter-spacing: .05em;">Nombre de la especialidad</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $especialidad->nombre) }}" required style="width: 100%; height: 48px; padding: 12px; border: 1px solid #e8e0d6; border-radius: 8px; background: #fff; color: #5a4b41; font-size: 14px;" />
                </div>

                <button type="submit" style="width: 100%; height: 48px; background: #6b5c4e; color: #fff; border: none; border-radius: 24px; font-size: 14px; cursor: pointer;">Actualizar Especialidad</button>
            </form>

            <div style="text-align: center; margin-top: 18px;">
                <a href="{{ route('admin.especialidades.index') }}" style="color: #6b5c4e; text-decoration: none; font-size: 13px;">← Volver a Especialidades</a>
            </div>
        </div>
    </div>
</body>
</html>