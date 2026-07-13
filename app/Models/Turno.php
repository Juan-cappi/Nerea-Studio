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
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function elServicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio');
    }

    public function elProfesional()
    {
        return $this->belongsTo(Profesional::class, 'profesional');
    }
}