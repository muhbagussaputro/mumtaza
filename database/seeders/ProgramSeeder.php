<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramJuzTarget;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get guru users
        $guru1 = User::where('role', 'guru')->first();
        $guru2 = User::where('role', 'guru')->skip(1)->first();

        if ($guru1) {
            // Program Reguler - Tahfidz 30 Juz
            $program1 = Program::create([
                'nama' => 'Tahfidz 30 Juz',
                'jenis' => 'reguler',
                'guru_id' => $guru1->id,
                'deskripsi' => 'Program hafalan Al-Quran 30 juz lengkap untuk siswa reguler',
            ]);

            // Add juz targets for program 1 (all 30 juz)
            for ($i = 1; $i <= 30; $i++) {
                ProgramJuzTarget::create([
                    'program_id' => $program1->id,
                    'juz_number' => $i,
                ]);
            }
        }

        if ($guru2) {
            // Program Khusus - Tahfidz 5 Juz
            $program2 = Program::create([
                'nama' => 'Tahfidz 5 Juz Pertama',
                'jenis' => 'khusus',
                'guru_id' => $guru2->id,
                'deskripsi' => 'Program hafalan Al-Quran 5 juz pertama untuk siswa pemula',
            ]);

            // Add juz targets for program 2 (first 5 juz)
            for ($i = 1; $i <= 5; $i++) {
                ProgramJuzTarget::create([
                    'program_id' => $program2->id,
                    'juz_number' => $i,
                ]);
            }

            // Program Khusus - Juz Amma
            $program3 = Program::create([
                'nama' => 'Juz Amma (Juz 30)',
                'jenis' => 'khusus',
                'guru_id' => $guru2->id,
                'deskripsi' => 'Program hafalan khusus Juz Amma untuk siswa tingkat dasar',
            ]);

            // Add juz target for program 3 (juz 30 only)
            ProgramJuzTarget::create([
                'program_id' => $program3->id,
                'juz_number' => 30,
            ]);
        }
    }
}
