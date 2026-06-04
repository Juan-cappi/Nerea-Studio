public function definition(): array
{
    return [
        // CARDINALIDAD: Crea automáticamente un usuario ficticio para asignarle este turno
        'user_id' => \App\Models\User::factory(), 
        'servicio' => fake()->randomElement(['Corte', 'Balayage', 'Alisado', 'Nutrición']),
        'profesional' => fake()->randomElement(['Ana', 'Clara', 'Barbi']),
        'fecha' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        'hora' => fake()->randomElement(['09:00', '10:00', '14:00', '16:00']),
        'estado' => fake()->randomElement(['pendiente', 'confirmado'])
    ];
}