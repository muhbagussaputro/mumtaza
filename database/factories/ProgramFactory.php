<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraph(),
            'jenis' => $this->faker->randomElement(['reguler', 'khusus']),
            'guru_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the program is reguler.
     */
    public function reguler(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis' => 'reguler',
        ]);
    }

    /**
     * Indicate that the program is khusus.
     */
    public function khusus(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis' => 'khusus',
        ]);
    }
}
