<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassStudentHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample classes
        $class1 = ClassRoom::create([
            'nama' => 'Kelas 1A',
            'tahun_ajaran' => '2024/2025',
        ]);

        $class2 = ClassRoom::create([
            'nama' => 'Kelas 1B',
            'tahun_ajaran' => '2024/2025',
        ]);

        $class3 = ClassRoom::create([
            'nama' => 'Kelas 2A',
            'tahun_ajaran' => '2024/2025',
        ]);

        // Assign students to classes
        $students = User::where('role', 'siswa')->get();

        if ($students->count() >= 2) {
            // Assign first student to class 1A
            ClassStudentHistory::create([
                'student_id' => $students[0]->id,
                'class_id' => $class1->id,
                'tahun_ajaran' => '2024/2025',
                'active' => true,
            ]);

            // Assign second student to class 1B
            ClassStudentHistory::create([
                'student_id' => $students[1]->id,
                'class_id' => $class2->id,
                'tahun_ajaran' => '2024/2025',
                'active' => true,
            ]);
        }
    }
}
