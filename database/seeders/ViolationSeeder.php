<?php

namespace Database\Seeders;

use App\Models\Violation;
use Illuminate\Database\Seeder;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $violations = [
            [
                'nama' => 'Kelupaan',
                'deskripsi' => 'Siswa lupa hafalan yang sudah disetorkan sebelumnya',
            ],
            [
                'nama' => 'Salah Bacaan',
                'deskripsi' => 'Kesalahan dalam membaca ayat Al-Quran',
            ],
            [
                'nama' => 'Tidak Lancar',
                'deskripsi' => 'Hafalan tidak lancar, sering terhenti atau ragu-ragu',
            ],
            [
                'nama' => 'Kurang Tartil',
                'deskripsi' => 'Bacaan kurang sesuai dengan kaidah tartil',
            ],
            [
                'nama' => 'Terlambat',
                'deskripsi' => 'Datang terlambat saat jadwal setoran',
            ],
            [
                'nama' => 'Tidak Hadir',
                'deskripsi' => 'Tidak hadir tanpa keterangan yang jelas',
            ],
        ];

        foreach ($violations as $violation) {
            Violation::create($violation);
        }
    }
}
