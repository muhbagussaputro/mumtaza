<?php

namespace Database\Factories;

use App\Models\Surah;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurahFactory extends Factory
{
    protected $model = Surah::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numberBetween(1, 114),
            'name_ar' => $this->faker->word(),
            'name_id' => $this->faker->optional()->word(),
            'juz' => $this->faker->optional()->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']),
            'revelation_place' => $this->faker->randomElement(['Mekah', 'Madinah']),
            'ayah_count' => $this->faker->numberBetween(3, 286),
        ];
    }
}
