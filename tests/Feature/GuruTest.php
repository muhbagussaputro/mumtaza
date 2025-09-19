<?php

use App\Models\Guru;
use App\Models\Program;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guru dashboard dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('guru.dashboard');
});

test('data siswa guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/data-siswa');

    $response->assertStatus(200);
    $response->assertViewIs('guru.data-siswa');
});

test('data hafalan guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/data-hafalan');

    $response->assertStatus(200);
    $response->assertViewIs('guru.data-hafalan');
});

test('hafalan index guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/hafalan');

    $response->assertStatus(200);
    $response->assertViewIs('guru.hafalan.index');
});

test('form create hafalan guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);
    $student = Siswa::factory()->create();

    $response = $this->actingAs($user)->get('/guru/siswa/'.$student->id.'/setoran/create');

    $response->assertStatus(200);
    $response->assertViewIs('guru.memorization.create');
});

test('laporan guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/laporan');

    $response->assertStatus(200);
    $response->assertViewIs('guru.laporan.index');
});

test('siswa index guru dapat diakses', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/guru/siswa');

    $response->assertStatus(200);
    $response->assertViewIs('guru.siswa.index');
});

test('guru dapat menyimpan hafalan baru', function () {
    $user = User::factory()->create(['role' => 'guru']);
    $guru = Guru::factory()->create(['user_id' => $user->id]);
    $student = Siswa::factory()->create();
    $program = Program::factory()->create();
    $surah = \App\Models\Surah::factory()->create(); // Create a Surah

    $hafalanData = [
        'student_id' => $student->id,
        'program_id' => $program->id,
        'surah_id' => $surah->id,
        'juz_number' => 1,
        'start_ayah' => 1,
        'end_ayah' => 5,
        'halaman' => 1,
        'ayat' => 1,
        'jadwal_setoran' => 'pagi',
        'keterangan' => 'lancar',
        'klasifikasi' => 'tercapai',
        'jenis_setoran' => 'tambah_hafalan',
        'has_violation' => false,
        'hadir' => true,
        'notes' => 'Bagus, lanjutkan',
    ];

    $response = $this->actingAs($user)->post('/guru/setoran', $hafalanData);

    // Assert successful redirect
    $response->assertStatus(302);
    $response->assertRedirect('/guru/data-hafalan');

    // Verify data was saved
    $this->assertDatabaseHas('memorization_entries', [
        'student_id' => $student->id,
        'program_id' => $program->id,
        'surah_id' => $surah->id,
        'juz_number' => 1,
        'halaman' => 1,
        'ayat' => 1,
        'jadwal_setoran' => 'pagi',
        'keterangan' => 'lancar',
        'klasifikasi' => 'tercapai',
        'jenis_setoran' => 'tambah_hafalan',
        'hadir' => 1,
        'notes' => 'Bagus, lanjutkan',
    ]);
});
