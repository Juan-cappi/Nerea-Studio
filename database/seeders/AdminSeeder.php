<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Los TRES roles del sistema
        $rolAdmin     = Role::firstOrCreate(['name' => 'admin']);
        $rolRecepcion = Role::firstOrCreate(['name' => 'recepcionista']);
        $rolCliente   = Role::firstOrCreate(['name' => 'cliente']);

        // Administrador
        $admin = User::updateOrCreate(
            ['email' => 'nerea@gmail.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('artemis123'),
            ]
        );
        $admin->roles()->sync([$rolAdmin->id]);

        // Recepcionista
        $recepcion = User::updateOrCreate(
            ['email' => 'recepcion@gmail.com'],
            [
                'name'     => 'Recepcionista Nerea',
                'password' => Hash::make('artemis123'),
            ]
        );
        $recepcion->roles()->sync([$rolRecepcion->id]);

        // Cliente de prueba (para la defensa)
        $cliente = User::updateOrCreate(
            ['email' => 'cliente@gmail.com'],
            [
                'name'     => 'Cliente de Prueba',
                'password' => Hash::make('artemis123'),
            ]
        );
        $cliente->roles()->sync([$rolCliente->id]);
    }
}