<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data
        $this->call([
            SurahSeeder::class,
            ViolationSeeder::class,
            UserSeeder::class,
            ClassRoomSeeder::class,
            ProgramSeeder::class,
            ClassStudentHistorySeeder::class,
            JuzTargetSeeder::class,
            ProgramJuzTargetSeeder::class,
            StudentProgramSeeder::class,
            HafalanSeeder::class,
        ]);
    }
}
