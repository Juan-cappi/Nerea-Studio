<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTurnoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre_completo' => 'required|string|max:255',
            'correo'          => 'required|email|max:255',
            'fecha'           => 'required|date',
            'hora'            => 'required|string',
            'servicio_id'     => 'required|exists:servicios,id',
            'profesional_id'  => 'required|exists:profesionales,id',
        ];
    }
}
