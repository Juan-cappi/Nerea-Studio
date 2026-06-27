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
        return $this->belongsTo(User::class);
    }

    // ✂️ Relación para el servicio (usamos 'service' para que no choque con la columna 'servicio')
    public function service()
    {
        return $this->belongsTo(Servicio::class, 'servicio');
    }

    // 💇‍♂️ Relación para el profesional (usamos 'professional' para que no choque con la columna 'profesional')
    public function professional()
    {
        return $this->belongsTo(Profesional::class, 'profesional');
    }
}