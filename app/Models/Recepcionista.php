<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recepcionista extends Model
{
    protected $table = 'Recepcionistas';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
    ];
}
