<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Profesional;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    // 1. Muestra el panel de coordinación (Formulario + Tabla de asignaciones)
    public function index()
    {
        $especialidades = Especialidad::all();
        // Traemos los profesionales con sus especialidades de la tabla intermedia
        $profesionales = Profesional::with('especialidades')->get(); 

        return view('admin.especialidades.index', compact('especialidades', 'profesionales'));
    }
        public function store(Request $request)
    {
        // Validamos que el nombre sea obligatorio y que no esté repetido
        $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:especialidades,nombre',
        ], [
            'nombre.required' => '⚠️ El nombre de la especialidad es obligatorio.',
            'nombre.unique' => '⚠️ Esta especialidad ya se encuentra registrada.',
        ]);

        // Creamos la especialidad en la base de datos
        \App\Models\Especialidad::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->back()->with('status_create', '¡Especialidad creada con éxito!');
    }

    // 2. Procesa la unión en la tabla intermedia (Especialidad ↔ Profesional)
    public function asignar(Request $request)
    {
        $request->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'especialidad_id' => 'required|exists:especialidades,id',
        ]);

        $profesional = Profesional::findOrFail($request->profesional_id);
        
       
        $profesional->especialidades()->syncWithoutDetaching([$request->especialidad_id]);

        return redirect()->back()->with('status', '¡Especialidad asignada al profesional con éxito!');
    }

}