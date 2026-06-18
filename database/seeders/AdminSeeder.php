<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        
        User::updateOrCreate(
            ['email'         => 'nerea@gmail.com'],
            [
            'name'          => 'Administrador',
            'password'      => Hash::make('artemis123'),
            'role'          => 'administrador',
        ]);   

        $recepcion = User::updateOrCreate(
            ['email'         => 'recepcion@gmail.com'],
            [
            'name'          => 'Recepcionista',
            'password'      => Hash::make('artemis123'),
            'role'          => 'recepcionista',
        ]);

    }
}
