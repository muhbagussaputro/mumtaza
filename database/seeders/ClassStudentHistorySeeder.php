<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassStudentHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClassStudentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data siswa dan kelas
        if (User::where('role', 'siswa')->count() == 0 || ClassRoom::count() == 0) {
            $this->command->info('Tidak ada data siswa atau kelas untuk diproses. Silakan jalankan UserSeeder dan ClassRoomSeeder terlebih dahulu.');

            return;
        }

        // Ambil semua siswa dan kelas
        $students = User::where('role', 'siswa')->get();
        $classRooms = ClassRoom::all();

        // Hapus data lama untuk menghindari duplikasi jika seeder dijalankan ulang
        Schema::disableForeignKeyConstraints();
        DB::table('class_student_histories')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($students as $student) {
            // Setiap siswa akan dimasukkan ke salah satu kelas secara acak
            $classRoom = $classRooms->random();

            ClassStudentHistory::create([
                'student_id' => $student->id,
                'class_id' => $classRoom->id,
                'tahun_ajaran' => $classRoom->tahun_ajaran,
                'active' => true, // Anggap semua aktif saat seeder dijalankan
            ]);
        }

        $this->command->info('ClassStudentHistorySeeder berhasil dijalankan. '.$students->count().' siswa telah dimasukkan ke dalam kelas.');
    }
}
