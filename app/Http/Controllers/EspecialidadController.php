<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Profesional;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index()
    {
        // Único listado paginado: profesionales con sus especialidades
        $profesionales = Profesional::with('especialidades')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        // Los selects del formulario necesitan TODOS los registros (no se paginan)
        $todosProfesionales  = Profesional::orderBy('nombre')->get();
        $todasEspecialidades = Especialidad::orderBy('nombre')->get();

        return view('admin.especialidades.index', compact(
            'profesionales',
            'todosProfesionales',
            'todasEspecialidades'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:especialidades,nombre',
        ], [
            'nombre.required' => '⚠️ El nombre de la especialidad es obligatorio.',
            'nombre.unique'   => '⚠️ Esta especialidad ya se encuentra registrada.',
        ]);

        Especialidad::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->back()->with('status_create', '¡Especialidad creada con éxito!');
    }

    public function asignar(Request $request)
    {
        $request->validate([
            'profesional_id'  => 'required|exists:profesionales,id',
            'especialidad_id' => 'required|exists:especialidades,id',
        ]);

        $profesional = Profesional::findOrFail($request->profesional_id);
        $profesional->especialidades()->syncWithoutDetaching([$request->especialidad_id]);

        return redirect()->back()->with('status', '¡Especialidad asignada al profesional con éxito!');
    }
}