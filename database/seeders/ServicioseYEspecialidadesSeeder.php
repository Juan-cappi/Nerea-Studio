<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidad;
use App\Models\Servicio;

class ServicioseYEspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. CREAMOS LAS TRES ESPECIALIDADES
        $peinador = Especialidad::create(['nombre' => 'Peinador/a']);
        $colorista = Especialidad::create(['nombre' => 'Colorista']);
        $asistente = Especialidad::create(['nombre' => 'Asistente']);

        
        // 2. SERVICIOS PARA PEINADOR/A (Todos duran 1 hora)
        $serviciosPeinador = ['Corte', 'Corte de flequillo', 'Peinado'];
        foreach ($serviciosPeinador as $nombre) {
            Servicio::create([
                'nombre' => $nombre,
                'duracion' => 1,
                'especialidad_id' => $peinador->id
            ]);
        }

       
        // 3. SERVICIOS PARA COLORISTA  
        // Servicios de 1 hora
        $colorista1hs = ['Coloración de raíces', 'Color completo'];
        foreach ($colorista1hs as $nombre) {
            Servicio::create([
                'nombre' => $nombre,
                'duracion' => 1,
                'especialidad_id' => $colorista->id
            ]);
        }
        
        // Servicios de 2 horas (Los bloques largos de tiempo)
        $colorista2hs = ['Mechas', 'Balayage', 'Gorra', 'Barrido'];
        foreach ($colorista2hs as $nombre) {
            Servicio::create([
                'nombre' => $nombre,
                'duracion' => 2,
                'especialidad_id' => $colorista->id
            ]);
        }

        
        // 4. SERVICIOS PARA ASISTENTE (Todos duran 1 hora)
        $serviciosAsistente = ['Alisados / keratina', 'Tratamientos', 'Lavado'];
        foreach ($serviciosAsistente as $nombre) {
            Servicio::create([
                'nombre' => $nombre,
                'duracion' => 1,
                'especialidad_id' => $asistente->id
            ]);
        }
    }
}