<?php

namespace Database\Factories;

use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemorizationEntryFactory extends Factory
{
    protected $model = MemorizationEntry::class;

    public function definition(): array
    {
        return [
            'student_id' => User::factory()->create(['role' => 'siswa']),
            'program_id' => Program::factory(),
            'guru_id' => User::factory()->create(['role' => 'guru']),
            'juz_number' => $this->faker->numberBetween(1, 30),
            'surah_id' => Surah::factory(),
            'halaman' => $this->faker->optional()->numberBetween(1, 604),
            'ayat' => $this->faker->optional()->numberBetween(1, 286),
            'jadwal_setoran' => $this->faker->randomElement(['pagi', 'siang', 'malam']),
            'jenis_setoran' => $this->faker->randomElement(['tambah_hafalan', 'murojaah_qorib', 'murojaah_bid']),
            'keterangan' => $this->faker->randomElement(['lancar', 'tidak_lancar']),
            'klasifikasi' => $this->faker->randomElement(['tercapai', 'tidak_tercapai']),
            'hadir' => true,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function forGuru($guruId)
    {
        return $this->state(function (array $attributes) use ($guruId) {
            return [
                'guru_id' => $guruId,
            ];
        });
    }
}
