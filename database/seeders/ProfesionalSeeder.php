<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profesional;
use App\Models\Especialidad;

class ProfesionalSeeder extends Seeder
{
    public function run(): void
    {
        $peinador  = Especialidad::where('nombre', 'Peinador/a')->first();
        $colorista = Especialidad::where('nombre', 'Colorista')->first();
        $asistente = Especialidad::where('nombre', 'Asistente')->first();

        $datos = [
            ['nombre' => 'Ana Torres',     'email' => 'ana@nereastudio.com',   'telefono' => '1145678901', 'Especialidad' => 'Peinador/a', 'esp' => [$peinador, $colorista]],
            ['nombre' => 'Clara Ruiz',     'email' => 'clara@nereastudio.com', 'telefono' => '1145678902', 'Especialidad' => 'Colorista',  'esp' => [$colorista]],
            ['nombre' => 'Barbi Gómez',    'email' => 'barbi@nereastudio.com', 'telefono' => '1145678903', 'Especialidad' => 'Asistente',  'esp' => [$asistente, $peinador]],
            ['nombre' => 'Lucía Fernández','email' => 'lucia@nereastudio.com', 'telefono' => '1145678904', 'Especialidad' => 'Peinador/a', 'esp' => [$peinador]],
        ];

        foreach ($datos as $d) {
            $profesional = Profesional::updateOrCreate(
                
                [
                    'email' => $d['email'],
                    'nombre'       => $d['nombre'],
                    'telefono'     => $d['telefono'],
                    'Especialidad' => $d['Especialidad'],
                ]
            );

            $ids = collect($d['esp'])->filter()->pluck('id')->all();
            $profesional->especialidades()->sync($ids);
        }
    }
}