<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\StudentProgram;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('role', 'siswa')->count() == 0 || Program::count() == 0) {
            $this->command->info('Tidak ada data siswa atau program untuk diproses. Silakan jalankan UserSeeder dan ProgramSeeder terlebih dahulu.');

            return;
        }

        $students = User::where('role', 'siswa')->get();
        $programs = Program::all();

        Schema::disableForeignKeyConstraints();
        DB::table('student_programs')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($students as $student) {
            // Setiap siswa akan dimasukkan ke salah satu program secara acak
            $program = $programs->random();

            StudentProgram::create([
                'student_id' => $student->id,
                'program_id' => $program->id,
                'started_at' => Carbon::now()->subMonths(rand(1, 6)),
                'finished_at' => null, // Belum selesai
                'progress_cached' => rand(0, 50) / 100, // Progress acak antara 0% - 50%
            ]);
        }

        $this->command->info('StudentProgramSeeder berhasil dijalankan. '.$students->count().' siswa telah didaftarkan ke program.');
    }
}
