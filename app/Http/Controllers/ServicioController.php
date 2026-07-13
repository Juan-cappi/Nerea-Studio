<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use App\Http\Requests\ServicioRequest;

class ServicioController extends Controller
{
    // 1. Muestra el panel con el formulario y el listado de servicios
    public function index()
    {
        // El listado SÍ se pagina
        $servicios = Servicio::with('specialty')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        // El select del formulario necesita TODAS las especialidades (no se pagina)
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('admin.servicios.index', compact('servicios', 'especialidades'));
    }

    // 2. Guarda el nuevo servicio en la base de datos
    public function store(ServicioRequest $request)
    {
        $validated = $request->validated();

        Servicio::create([
            'nombre' => $validated['nombre'],
            'especialidad_id' => $validated['especialidad_id'],
            'duracion' => $validated['duracion'] ?? 1,
            'precio' => $validated['precio'] ?? null,
        ]);

        return redirect()->back()->with('status', '¡Servicio creado con éxito!');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('admin.servicios.edit', compact('servicio', 'especialidades'));
    }

    public function update(ServicioRequest $request, $id)
    {
        $validated = $request->validated();

        $servicio = Servicio::findOrFail($id);
        $servicio->update([
            'nombre' => $validated['nombre'],
            'especialidad_id' => $validated['especialidad_id'],
            'duracion' => $validated['duracion'] ?? $servicio->duracion,
            'precio' => $validated['precio'] ?? $servicio->precio,
        ]);

        return redirect()->route('admin.servicios.index')->with('status', '¡Servicio actualizado con éxito!');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('admin.servicios.index')->with('status', '¡Servicio eliminado con éxito!');
    }
}