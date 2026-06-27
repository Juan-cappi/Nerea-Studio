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
        return view('admin.profesionales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataValidada = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required||max:20',  
            'especialidad' => 'required|exists:especialidad|id',
        ]);

        $profesional = Profesional::create([
            'nombre' => $dataValidada['nombre'],
            'email' => $dataValidada['email'],
            'telefono' => $dataValidada['telefono'],
        ]);

        $profesional->especialidades()->attach($request->especialidad_id);
        
        return redirect()->back()->with('success','Profesional creado correctamente con su especialidad');
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
        $profesional = Profesional::findOrFail($id);
        return view('admin.profesionales.edit', compact('profesional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required||max:20',
            'especialidad' => 'required|string|max:255',
        ]);
        $profesional = Profesional::findOrFail($id);

        $profesional->update($request->all());
        return redirect()->route('admin.dashboard')
        ->with('success','Profesional actualizado correctamente');
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
