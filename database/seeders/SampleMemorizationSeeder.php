<?php

namespace Database\Seeders;

use App\Models\Memorization;
use App\Models\MemorizationEvaluation;
use App\Models\Surah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleMemorizationSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample users (student and teacher)
        $student = User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );

        $teacher = User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Demo',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        // Ensure Surahs are available
        $fatihah = Surah::where('number', 1)->first();
        $baqarah = Surah::where('number', 2)->first();

        if (!$fatihah || !$baqarah) {
            // If surahs table is empty, run SurahSeeder first
            $this->call(SurahSeeder::class);
            $fatihah = Surah::where('number', 1)->firstOrFail();
            $baqarah = Surah::where('number', 2)->firstOrFail();
        }

        // Create sample memorizations
        $m1 = Memorization::create([
            'user_id' => $student->id,
            'surah_id' => $fatihah->id,
            'start_ayah' => 1,
            'end_ayah' => 7,
            'memorized_at' => Carbon::now()->subDays(2)->toDateString(),
            'status' => 'submitted',
            'notes' => 'Setoran Al-Fatihah',
        ]);

        $m2 = Memorization::create([
            'user_id' => $student->id,
            'surah_id' => $baqarah->id,
            'start_ayah' => 1,
            'end_ayah' => 5,
            'memorized_at' => Carbon::now()->subDay()->toDateString(),
            'status' => 'in_progress',
            'notes' => 'Mulai Al-Baqarah 1-5',
        ]);

        // Create evaluations
        MemorizationEvaluation::create([
            'memorization_id' => $m1->id,
            'evaluator_id' => $teacher->id,
            'evaluated_at' => Carbon::now()->subDay()->toDateString(),
            'accuracy_score' => 90,
            'tajwid_score' => 85,
            'fluency_score' => 88,
            'memorization_score' => 92,
            'overall_score' => 89,
            'mistake_count' => 3,
            'remarks' => 'Pembacaan baik, perbaiki mad pada ayat 4.',
            'result' => 'passed',
        ]);

        // Optional: partial evaluation for m2 (draft)
        MemorizationEvaluation::create([
            'memorization_id' => $m2->id,
            'evaluator_id' => $teacher->id,
            'evaluated_at' => Carbon::now()->toDateString(),
            'accuracy_score' => 75,
            'tajwid_score' => 70,
            'fluency_score' => 72,
            'memorization_score' => 78,
            'overall_score' => 74,
            'mistake_count' => 6,
            'remarks' => 'Masih ragu di ayat 2-3, ulangi latihan.',
            'result' => 'revision',
        ]);
    }
}
