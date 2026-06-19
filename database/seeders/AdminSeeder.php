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
        // 1. Se crea o actualiza el Administrador
        $admin = User::updateOrCreate(
            ['email'          => 'nerea@gmail.com'],
            [
                'name'        => 'Administrador',
                'password'    => Hash::make('artemis123'),
                'role'        => 'administrador',
            ]
        );

        // 2. Se crea o actualiza la Recepcionista
        $recepcion = User::updateOrCreate(
            ['email'          => 'recepcion@nerea.com'],
            [
                'name'        => 'Recepcionista Nerea',
                'password'    => Hash::make('12345678'),
                'role'        => 'recepcionista',
            ]
        );

   
        $rolAdmin = \App\Models\role::updateOrCreate(['name' => 'admin']);
        $rolRecepcion = \App\Models\role::updateOrCreate(['name' => 'recepcionista']);

        $admin->roles()->syncWithoutDetaching([$rolAdmin->id]);
        $recepcion->roles()->syncWithoutDetaching([$rolRecepcion->id]);
    }
}

