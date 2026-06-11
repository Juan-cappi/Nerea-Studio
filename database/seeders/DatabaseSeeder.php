<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(AdminSeeder::class);

        // Genera 30 turnos aleatorios en la base de datos al toque
        \App\Models\Turno::factory(30)->create();
        
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        /* lOGICA VIEJA DE ROLES 
        $roles = ['admin','recepcionista', 'cliente'];
        foreach($roles as $name){
            role::create([
                'name' => $name
            ]);
        }*/


    }
}