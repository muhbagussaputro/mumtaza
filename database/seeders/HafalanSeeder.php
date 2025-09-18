<?php

namespace Database\Seeders;

use App\Models\Hafalan;
use App\Models\StudentProgram;
use App\Models\Surah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HafalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (StudentProgram::count() == 0 || Surah::count() == 0) {
            $this->command->info('Tidak ada data program siswa atau surah. Jalankan StudentProgramSeeder dan SurahSeeder terlebih dahulu.');

            return;
        }

        $studentPrograms = StudentProgram::all();
        $surahs = Surah::all();

        DB::table('hafalan')->truncate();

        foreach ($studentPrograms as $studentProgram) {
            // Buat beberapa entri hafalan untuk setiap siswa dalam program
            for ($i = 0; $i < rand(5, 15); $i++) {
                $surah = $surahs->random();
                $startAyat = rand(1, 20);

                Hafalan::create([
                    'id_program_siswa' => $studentProgram->id,
                    'waktu' => collect(['pagi', 'sore', 'malam'])->random(),
                    'kehadiran' => collect(['hadir', 'izin'])->random(),
                    'id_surat' => $surah->id,
                    'ayat_mulai' => $startAyat,
                    'ayat_selesai' => $startAyat + rand(1, 5),
                    'jenis_hafalan' => collect(['Tambah hafalan', 'Murojaah Qorib', 'Murojaah Bid'])->random(),
                    'target' => collect(['tercapai', 'tidak tercapai'])->random(),
                    'keterangan' => collect(['lancar', 'tidak lancar'])->random(),
                    'komentar' => 'Ini adalah komentar acak untuk hafalan.',
                    'pelanggaran' => 'tidak',
                    'ket_pelanggaran' => null,
                    'halaman' => rand(1, 604),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('HafalanSeeder berhasil dijalankan.');
    }
}
