<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'especialidad_id', 'duracion', 'precio'];

    // 🏷️ Relación: Un servicio pertenece a una especialidad (Ej: Balayage pertenece a Colorista)
    public function specialty()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }
}