<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Profesional;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::orderBy('nombre')->paginate(10);
        $todasEspecialidades = Especialidad::orderBy('nombre')->get();
        $todosProfesionales = Profesional::orderBy('nombre')->get();
        $profesionales = Profesional::with('especialidades')
            ->orderBy('nombre')
            ->paginate(5, ['*'], 'pag_prof')
            ->withQueryString();

        return view('admin.especialidades.index', compact('especialidades', 'todasEspecialidades', 'todosProfesionales', 'profesionales'));
    }

    public function create()
    {
        return view('admin.especialidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:especialidades',
        ]);

        Especialidad::create($validated);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad creada exitosamente.');
    }

    public function edit(Especialidad $especialidad)
    {
        return view('admin.especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:especialidades,nombre,' . $especialidad->id,
        ]);

        $especialidad->update($validated);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad actualizada exitosamente.');
    }

    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad eliminada exitosamente.');
    }

    public function asignar(Request $request)
    {
        $request->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'especialidad_id' => 'required|exists:especialidades,id',
        ]);

        $especialidad = Especialidad::findOrFail($request->especialidad_id);
        $especialidad->profesionales()->syncWithoutDetaching([$request->profesional_id]);

        return redirect()->back()->with('success', 'Especialidad asignada al profesional correctamente.');
    }
}