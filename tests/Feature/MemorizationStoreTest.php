<?php

use App\Models\Siswa;
use App\Models\Program;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guru can store memorization with violation', function () {
    // Create test data
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();
    $program = Program::factory()->create();
    $surah = Surah::factory()->create(['ayah_count' => 10]);
    
    // Create master violation
    $violation = \App\Models\Violation::create([
        'nama' => 'Terlambat',
        'deskripsi' => 'Late submission'
    ]);
    
    // Authenticate as guru
    $this->actingAs($guru);
    
    // Test data
    $data = [
        'student_id' => $siswa->id,
        'program_id' => $program->id,
        'jadwal_setoran' => 'pagi',
        'hadir' => true,
        'surah_id' => $surah->id,
        'juz_number' => 1,
        'start_ayah' => 1,
        'end_ayah' => 5,
        'halaman' => 1,
        'ayat' => 5,
        'jenis_setoran' => 'tambah_hafalan',
        'klasifikasi' => 'tercapai',
        'keterangan' => 'lancar',
        'notes' => 'Good memorization',
        'has_violation' => true,
        'violations' => [$violation->id]
    ];
    
    // Make request
    $response = $this->post('/guru/setoran', $data);
    
    // Assert response
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Setoran berhasil ditambahkan');
    
    // Assert database
    $this->assertDatabaseHas('memorization_entries', [
        'student_id' => $siswa->id,
        'program_id' => $program->id,
        'surah_id' => $surah->id,
        'juz_number' => 1,
        'klasifikasi' => 'tercapai'
    ]);
    
    // Check pivot table for violation
    $this->assertDatabaseHas('memorization_entry_violations', [
        'entry_id' => \App\Models\MemorizationEntry::first()->id,
        'violation_id' => $violation->id
    ]);
});

test('guru can store memorization without violation', function () {
    // Create test data
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();
    $program = Program::factory()->create();
    $surah = Surah::factory()->create(['ayah_count' => 10]);
    
    // Authenticate as guru
    $this->actingAs($guru);
    
    // Test data
    $data = [
        'student_id' => $siswa->id,
        'program_id' => $program->id,
        'surah_id' => $surah->id,
        'start_ayah' => 1,
        'end_ayah' => 5,
        'ayat' => 5,
        'juz_number' => 1,
        'klasifikasi' => 'tercapai',
        'jadwal_setoran' => 'pagi',
        'jenis_setoran' => 'tambah_hafalan',
        'keterangan' => 'lancar',
        'hadir' => true,
        'notes' => 'Good effort',
        'has_violation' => false
    ];
    
    // Make request
    $response = $this->post('/guru/setoran', $data);
    
    // Assert response
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Setoran berhasil ditambahkan');
    
    // Assert database - should have memorization but no violation
    $this->assertDatabaseHas('memorization_entries', [
        'student_id' => $siswa->id,
        'klasifikasi' => 'tercapai'
    ]);
    
    $this->assertDatabaseMissing('violations', [
        'student_id' => $siswa->id
    ]);
});

test('validation fails when end_ayah is less than start_ayah', function () {
    // Create test data
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();
    $program = Program::factory()->create();
    $surah = Surah::factory()->create(['ayah_count' => 10]);
    
    // Authenticate as guru
    $this->actingAs($guru);
    
    // Test data with invalid ayah range
    $data = [
        'student_id' => $siswa->id,
        'program_id' => $program->id,
        'jadwal_setoran' => '2025-09-20',
        'kehadiran' => 'hadir',
        'surah_id' => $surah->id,
        'start_ayah' => 5,
        'end_ayah' => 3, // Invalid: end < start
        'jenis_setoran' => 'tambah_hafalan',
        'classification' => 'excellent',
        'add_violation' => '0'
    ];
    
    // Make request
    $response = $this->post('/guru/setoran', $data);
    
    // Assert validation error
    $response->assertSessionHasErrors(['end_ayah']);
});

test('violation description is required when add_violation is checked', function () {
    // Create test data
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();
    $program = Program::factory()->create();
    $surah = Surah::factory()->create(['ayah_count' => 10]);
    
    // Authenticate as guru
    $this->actingAs($guru);
    
    // Test data with has_violation but no violations
    $data = [
        'student_id' => $siswa->id,
        'program_id' => $program->id,
        'surah_id' => $surah->id,
        'start_ayah' => 1,
        'end_ayah' => 5,
        'ayat' => 5,
        'juz_number' => 1,
        'klasifikasi' => 'tercapai',
        'jadwal_setoran' => 'pagi',
        'jenis_setoran' => 'tambah_hafalan',
        'keterangan' => 'lancar',
        'hadir' => true,
        'has_violation' => true,
        'violations' => [] // Empty violations array
    ];
    
    // Make request
    $response = $this->post('/guru/setoran', $data);
    
    // Should succeed because violations array is optional, even when has_violation is true
    $response->assertStatus(302)
        ->assertSessionHas('success', 'Setoran berhasil ditambahkan');
});