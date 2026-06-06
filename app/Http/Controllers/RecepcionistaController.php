<?php

namespace App\Http\Controllers;

use App\Models\Recepcionista;
use Illuminate\Http\Request;

class RecepcionistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.receptionist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'telefono' => 'required|max:20',
        ]);

        Recepcionista::create($request->all());

        return redirect()->route('admin.dashboard')
        ->with('success','Recepcionista creado correctamente');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Recepcionista $recepcionista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recepcionista $recepcionista)
    {
        return view('admin.receptionist.edit', compact('recepcionista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recepcionista $recepcionista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recepcionista $recepcionista)
    {
        //
    }
}
