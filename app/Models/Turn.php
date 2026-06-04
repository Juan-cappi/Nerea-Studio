<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    /**
     * ASIGNACIÓN MASIVA: Campos autorizados a ser rellenados desde los formularios.
     * Esto protege la base de datos de inyecciones de código malicioso de usuarios.
     */
    protected $fillable = [
        'user_id',
        'servicio',
        'profesional',
        'fecha',
        'hora',
        'estado'
    ];

    /**
     * CARDINALIDAD: Un turno pertenece a un único Usuario (Cliente).
     * Permite a la recepcionista hacer: $turno->user->name para ver quién reservó.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}