<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $servicio = $this->route('servicio');
        $servicioId = $servicio instanceof \App\Models\Servicio ? $servicio->id : ($this->route('id') ?? $servicio);

        return [
            'nombre' => 'required|string|min:3|max:50|unique:servicios,nombre,' . $servicioId,
            'especialidad_id' => 'required|exists:especialidades,id',
            'duracion' => 'nullable|integer|min:1|max:2',
            'precio' => 'nullable|numeric|min:0',
        ];
    }
}
