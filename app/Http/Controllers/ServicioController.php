<?php

namespace App\Http\Controllers;
use App\Models\Servicio;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // 1. Muestra el panel con el formulario y el listado de servicios
    public function index()
    {
        $servicios = Servicio::with('specialty')->get();
        $especialidades = Especialidad::all(); // Para llenar el select del formulario

        return view('admin.servicios.index', compact('servicios', 'especialidades'));
    }

    // 2. Guarda el nuevo servicio en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:servicios,nombre',
            'especialidad_id' => 'required|exists:especialidades,id',
        ], [
            'nombre.required' => '⚠️ El nombre del servicio es obligatorio.',
            'nombre.unique' => '⚠️ Este servicio ya existe.',
            'especialidad_id.required' => '⚠️ Tenés que asignarle una especialidad.',
        ]);

        Servicio::create([
            'nombre' => $request->nombre,
            'especialidad_id' => $request->especialidad_id,
        ]);

        return redirect()->back()->with('status', '¡Servicio creado con éxito!');
    }
}