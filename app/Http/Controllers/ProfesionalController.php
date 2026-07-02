<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesional;

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
            // 🔮 Buscamos todas las especialidades reales en MySQL
            $especialidades = \App\Models\Especialidad::all();

            // 🎒 Se las pasamos a la vista usando compact
            return view('admin.Profesionales.create', compact('especialidades'));
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos básicos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:profesionales,email',
            'telefono' => 'required|string',
            'especialidad_id' => 'required|exists:especialidades,id', // Asegurate de que coincida con el 'name' de tu <select>
        ]);

        // 2. Creamos el registro del profesional a mano para saltear el $fillable
            $especialidadReal = \App\Models\Especialidad::find($request->especialidad_id);

            $profesional = new Profesional();
            $profesional->nombre = $request->nombre;
            $profesional->email = $request->email;
            $profesional->telefono = $request->telefono;
            $profesional->Especialidad = $especialidadReal->nombre; // ◄ Forzamos la columna vieja tal cual se llama en la BD
            $profesional->save(); // Guardamos en la tabla 'profesionales'

            // 3. ¡EL TRUCO CLAVE! Enganchamos al nuevo profesional en la tabla intermedia
            $profesional->especialidades()->attach($request->especialidad_id);

        // 4. 🧭 ¡REDIRECCIÓN AL PANEL! En vez de quedarnos ahí, lo mandamos al dashboard con un mensaje de éxito
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
        
        // 🔮 Buscamos todas las especialidades disponibles para el select
        $especialidades = \App\Models\Especialidad::all();

        // 🎒 Enviamos las dos variables juntas a la vista
        return view('admin.Profesionales.edit', compact('profesional', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:profesionales,email,' . $id,
        'telefono' => 'required|string',
        'especialidad_id' => 'required|exists:especialidades,id',
    ]);

    $profesional = Profesional::findOrFail($id);
    $especialidadReal = \App\Models\Especialidad::find($request->especialidad_id);

    // Actualizamos los campos individuales salteando trabas de fillable
    $profesional->nombre = $request->nombre;
    $profesional->email = $request->email;
    $profesional->telefono = $request->telefono;
    $profesional->Especialidad = $especialidadReal->nombre; // Mantenemos la columna vieja con el texto string
    $profesional->save();

    // 🔗 ¡LA CLAVE DE LA EDICIÓN! 
    // sync() borra la relación vieja en la tabla intermedia y clava la nueva automáticamente
    $profesional->especialidades()->sync([$request->especialidad_id]);

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
