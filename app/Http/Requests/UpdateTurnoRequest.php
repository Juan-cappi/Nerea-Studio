<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTurnoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'servicio_id'    => 'required|exists:servicios,id',
            'profesional_id' => 'required|exists:profesionales,id',
            'fecha'          => 'required|date',
            'hora'           => 'required|string',
        ];
    }
}
