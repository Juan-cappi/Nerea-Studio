<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $table = 'profesionales';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'especialidad',
    ];
}
