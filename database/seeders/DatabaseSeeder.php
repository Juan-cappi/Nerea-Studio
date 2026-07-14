<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(ServicioseYEspecialidadesSeeder::class);
        $this->call(ProfesionalSeeder::class);
        $this->call(RecepcionistaSeeder::class);

        \App\Models\Turno::factory(30)->create();
    }
}