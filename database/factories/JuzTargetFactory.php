<?php

namespace Database\Factories;

use App\Models\JuzTarget;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class JuzTargetFactory extends Factory
{
    protected $model = JuzTarget::class;

    public function definition(): array
    {
        return [
            'program_id' => Program::factory(),
            'juz_number' => $this->faker->numberBetween(1, 30),
            'target_pages' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->sentence(),
        ];
    }
}