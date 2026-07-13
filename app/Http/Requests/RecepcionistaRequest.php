<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecepcionistaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('recepcionista')?->id ?? $this->route('id');

        return [
            'nombre'=> 'required|string|max:255',
            'email'=> 'required|email|max:255|unique:recepcionistas,email,' . $id,
            'telefono' => 'required|max:20',
        ];
    }
}
