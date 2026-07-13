<?php

use App\Models\Profesional;
use App\Models\Turno;
use App\Models\User;
use App\Models\Role;

it('muestra los profesionales y turnos reales en el panel del recepcionista', function () {
    // 1. Creamos el usuario común usando el factory
    $user = User::factory()->create();

    // 2. Buscamos o creamos el rol usando 'name' en inglés
    $rolRecepcionista = Role::firstOrCreate(['name' => 'recepcionista']);

    // 3. Asociamos el usuario con el rol en la tabla intermedia
    $user->roles()->attach($rolRecepcionista);

    Profesional::create([
        'nombre' => 'Mateo',
        'email' => 'mateo@example.com',
        'telefono' => '123456789',
        'Especialidad' => 'Corte',
    ]);

    Turno::create([
        'user_id' => $user->id,
        'servicio' => 'Corte',
        'profesional' => 'Mateo',
        'fecha' => '2026-07-02',
        'hora' => '11:00',
        'estado' => 'pendiente',
    ]);

    $response = $this->actingAs($user)->get(route('recepcionista.dashboard', ['fecha' => '2026-07-02']));

    $response->assertOk();
    $response->assertSee('Mateo');
    $response->assertSee('11:00');
    $response->assertSee('Ocupado');
    $response->assertSee('Disponible');
    $response->assertSee('dot-partial');
});