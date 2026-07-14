<?php

namespace Database\Factories;

use App\Models\Turno;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Profesional;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::inRandomOrder()->first()?->id ?? User::factory(),
            'servicio'    => (string) Servicio::inRandomOrder()->first()?->id,
            'profesional' => (string) Profesional::inRandomOrder()->first()?->id,
            'fecha'       => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'hora'        => fake()->randomElement(['09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00']),
            'estado'      => 'confirmado',
        ];
    }
}