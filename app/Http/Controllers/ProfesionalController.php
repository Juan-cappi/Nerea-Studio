<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesional;
use App\Http\Requests\ProfesionalRequest;

class ProfesionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesionales= Profesional::all();
        return view('admin.profesionales.index', compact('profesionales'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
        {
            
            $especialidades = \App\Models\Especialidad::all();

     
            return view('admin.Profesionales.create', compact('especialidades'));
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfesionalRequest $request)
    {
        $validated = $request->validated();

        $especialidadReal = \App\Models\Especialidad::find($validated['especialidad_id']);

        $profesional = new Profesional();
        $profesional->nombre = $validated['nombre'];
        $profesional->email = $validated['email'];
        $profesional->telefono = $validated['telefono'];
        $profesional->Especialidad = $especialidadReal->nombre; 
        $profesional->save(); 

        $profesional->especialidades()->attach($validated['especialidad_id']);

        return redirect('/admin/dashboard')->with('status', '¡Profesional creado y vinculado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Buscamos al profesional trayendo sus especialidades vinculadas
        $profesional = Profesional::with('especialidades')->findOrFail($id);
        
        
        $especialidades = \App\Models\Especialidad::all();

       
        return view('admin.Profesionales.edit', compact('profesional', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(ProfesionalRequest $request, $id)
{
    $validated = $request->validated();

    $profesional = Profesional::findOrFail($id);
    $especialidadReal = \App\Models\Especialidad::find($validated['especialidad_id']);

    $profesional->nombre = $validated['nombre'];
    $profesional->email = $validated['email'];
    $profesional->telefono = $validated['telefono'];
    $profesional->Especialidad = $especialidadReal->nombre;
    $profesional->save();

    $profesional->especialidades()->sync([$validated['especialidad_id']]);

    return redirect('/admin/dashboard')->with('status', '¡Profesional actualizado con éxito!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $profesional = Profesional::findOrFail($id);
        $profesional->delete();
        return redirect()->route('admin.dashboard') 
        ->with('success','Profesional eliminado correctamente');

    }
}
