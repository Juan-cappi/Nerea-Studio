<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recepcionista;

class RecepcionistaSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['nombre' => 'Sofía Martínez', 'email' => 'sofia@nereastudio.com', 'telefono' => '1145670001'],
            ['nombre' => 'Camila Ortiz',   'email' => 'camila@nereastudio.com', 'telefono' => '1145670002'],
            ['nombre' => 'Julieta Peña',   'email' => 'julieta@nereastudio.com', 'telefono' => '1145670003'],
        ];

        foreach ($datos as $d) {
            Recepcionista::updateOrCreate(
                ['email' => $d['email']],
                [
                    'nombre'   => $d['nombre'],
                    'telefono' => $d['telefono'],
                ]
            );
        }
    }
}