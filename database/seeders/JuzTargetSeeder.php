<?php

namespace Database\Seeders;

use App\Models\JuzTarget;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuzTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('juz_targets')->truncate();

        $programs = Program::all();

        if ($programs->isEmpty()) {
            $this->command->info('Tidak ada program yang tersedia. Silakan jalankan ProgramSeeder terlebih dahulu.');

            return;
        }

        foreach ($programs as $program) {
            for ($i = 1; $i <= 30; $i++) {
                JuzTarget::create([
                    'program_id' => $program->id,
                    'juz_number' => $i,
                    'description' => 'Target hafalan untuk Juz '.$i,
                ]);
            }
        }

        $this->command->info('JuzTargetSeeder berhasil dijalankan. 30 Juz target telah dibuat untuk setiap program.');
    }
}
