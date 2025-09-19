<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassRoomFactory extends Factory
{
    protected $model = ClassRoom::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['Kelas 1A', 'Kelas 1B', 'Kelas 2A', 'Kelas 2B', 'Kelas 3A', 'Kelas 3B']),
            'tahun_ajaran' => $this->faker->randomElement(['2023/2024', '2024/2025', '2025/2026']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}