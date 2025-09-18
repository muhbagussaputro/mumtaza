<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramJuzTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramJuzTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Program::count() == 0) {
            $this->command->info('Tidak ada data program. Jalankan ProgramSeeder terlebih dahulu.');

            return;
        }

        $programs = Program::all();

        DB::table('program_juz_targets')->truncate();

        foreach ($programs as $program) {
            // Setiap program akan memiliki beberapa target juz secara acak (nomor 1-30)
            $juzNumbers = range(1, 30);
            shuffle($juzNumbers);
            $selectedJuzNumbers = array_slice($juzNumbers, 0, rand(2, 5));

            foreach ($selectedJuzNumbers as $juzNumber) {
                ProgramJuzTarget::create([
                    'program_id' => $program->id,
                    'juz_number' => $juzNumber,
                ]);
            }
        }

        $this->command->info('ProgramJuzTargetSeeder berhasil dijalankan.');
    }
}
