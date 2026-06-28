<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';

    protected $fillable = [
        'user_id',
        'servicio',
        'profesional',
        'fecha',
        'hora',
    ];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function profesional()
{
    return $this->belongsTo(Profesional::class, 'profesional_id');
}

public function servicio()
{
    // Si tu tabla de turnos guarda directamente el ID del servicio o el nombre
    // Cambiá 'servicio_id' por la columna con la que se conecte en tu base de datos
    return $this->belongsTo(Servicio::class, 'servicio_id');
}
}