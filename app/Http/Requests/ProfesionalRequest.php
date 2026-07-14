<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesionalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('profesional');
        $id = $id instanceof \App\Models\Profesional ? $id->id : $id;

        return [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:profesionales,email,' . $id,
            'telefono' => 'required|string',
            'especialidad_id' => 'required|exists:especialidades,id',
        ];
    }
}
