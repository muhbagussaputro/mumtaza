<?php

namespace Database\Factories;

use App\Models\Violation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViolationFactory extends Factory
{
    protected $model = Violation::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
