<?php

use App\Models\Profesional;
use App\Models\Turno;
use App\Models\User;

it('muestra los profesionales y turnos reales en el panel del recepcionista', function () {
    $user = User::factory()->create();

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
