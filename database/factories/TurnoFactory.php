<?php

namespace Database\Factories;

use App\Models\Turno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turno>
 */
class TurnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), 
            'servicio' => fake()->randomElement(['Corte', 'Balayage', 'Alisado', 'Nutrición']),
            'profesional' => fake()->randomElement(['Ana', 'Clara', 'Barbi']),
            'fecha' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora' => fake()->randomElement(['09:00', '10:00', '14:00', '16:00']),
        ];
    }
}
