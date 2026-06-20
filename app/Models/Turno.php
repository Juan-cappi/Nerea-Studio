<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';

    // Registramos solo las tres columnas reales para evitar trabas de asignación
   protected $fillable = [
    'user_id',
    'servicio',
    'profesional',
    'fecha',
    'hora',
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}