<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nis' => $this->faker->unique()->numerify('#######'),
            'foto_profil' => $this->faker->optional()->imageUrl(),
            'email' => $this->faker->unique()->safeEmail(),
            'telepon' => $this->faker->phoneNumber(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'nama_orang_tua' => $this->faker->name(),
            'id_kelas' => ClassRoom::factory(),
            'jenis' => $this->faker->randomElement(['regular', 'khusus']),
            'tahun_masuk' => $this->faker->year(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}