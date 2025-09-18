<?php

namespace Database\Seeders;

use App\Models\Memorization;
use App\Models\MemorizationProgram;
use App\Models\MemorizationProgramItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleProgramSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('email', 'siswa@example.com')->first();
        if (! $student) {
            $this->call(SampleMemorizationSeeder::class);
            $student = User::where('email', 'siswa@example.com')->firstOrFail();
        }

        // Create a 2-juz program for the student
        $program = MemorizationProgram::updateOrCreate(
            [
                'user_id' => $student->id,
                'name' => 'Program 2 Juz Demo',
            ],
            [
                'description' => 'Program contoh untuk menghafal 2 juz (Juz 1-2).',
                'start_date' => Carbon::now()->toDateString(),
                'target_juz_count' => 2,
                'status' => 'active',
            ]
        );

        // Create items for juz 1 and 2
        foreach ([1, 2] as $juz) {
            MemorizationProgramItem::updateOrCreate(
                [
                    'program_id' => $program->id,
                    'juz_number' => $juz,
                ],
                [
                    'title' => 'Juz '.$juz,
                    'target_date' => Carbon::now()->addWeeks($juz)->toDateString(),
                    'status' => 'planned',
                ]
            );
        }

        // Link existing memorizations to this program if any
        Memorization::where('user_id', $student->id)
            ->whereNull('program_id')
            ->update(['program_id' => $program->id]);
    }
}
