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
        'Especialidad',
        'especialidad',
    ];
    /**
 * ✨ Relación: Un profesional puede tener muchas especialidades
 */
public function especialidades()
{
    // 🧼 Lo dejamos estándar para que Laravel use las columnas perfectas que creaste
    return $this->belongsToMany(Especialidad::class);
}
}
