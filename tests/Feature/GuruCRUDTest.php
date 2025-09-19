<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\JuzTarget;
use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruCRUDTest extends TestCase
{
    use RefreshDatabase;

    private $guruUser;

    private $guru;

    private $student;

    private $program;

    private $surah;

    private $violation;

    protected function setUp(): void
    {
        parent::setUp();

        // Create guru user
        $this->guruUser = User::factory()->create([
            'role' => 'guru',
            'email' => 'guru@test.com',
        ]);

        $this->guru = Guru::factory()->create();

        // Create test data
        $this->student = User::factory()->create(['role' => 'siswa']);
        $this->program = Program::factory()->create();
        $this->surah = Surah::factory()->create();
        $this->violation = \App\Models\Violation::factory()->create();
    }

    public function test_guru_can_access_dashboard()
    {
        $response = $this->actingAs($this->guruUser)->get('/guru/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('guru.dashboard');
    }

    public function test_guru_can_access_data_siswa()
    {
        $response = $this->actingAs($this->guruUser)->get('/guru/data-siswa');

        $response->assertStatus(200);
        $response->assertViewIs('guru.data-siswa');
    }

    public function test_guru_can_access_data_hafalan()
    {
        $response = $this->actingAs($this->guruUser)->get('/guru/data-hafalan');

        $response->assertStatus(200);
        $response->assertViewIs('guru.data-hafalan');
    }

    public function test_guru_can_access_laporan()
    {
        $response = $this->actingAs($this->guruUser)->get('/guru/laporan');

        $response->assertStatus(200);
        $response->assertViewIs('guru.laporan.index');
    }

    public function test_guru_can_access_siswa_index()
    {
        $response = $this->actingAs($this->guruUser)->get('/guru/siswa');

        $response->assertStatus(200);
        $response->assertViewIs('guru.siswa.index');
    }

    public function test_guru_can_create_memorization_entry()
    {
        $juzTarget = JuzTarget::factory()->create();

        $entryData = [
            'student_id' => $this->student->id,
            'program_id' => $this->program->id,
            'surah_id' => $this->surah->id,
            'juz_target_id' => $juzTarget->id,
            'juz_number' => 1,
            'start_ayah' => 1,
            'end_ayah' => 5,
            'halaman' => 1,
            'ayat' => 1,
            'jadwal_setoran' => 'pagi',
            'jenis_setoran' => 'tambah_hafalan',
            'keterangan' => 'lancar',
            'klasifikasi' => 'tercapai',
            'hadir' => true,
            'has_violation' => false,
        ];

        $response = $this->actingAs($this->guruUser)->post('/guru/setoran', $entryData);

        $response->assertStatus(302); // Redirect after success
        $this->assertDatabaseHas('memorization_entries', [
            'student_id' => $this->student->id,
            'program_id' => $this->program->id,
            'guru_id' => $this->guruUser->id,
            'juz_number' => 1,
            'surah_id' => $this->surah->id,
            'halaman' => 1,
            'ayat' => 1,
            'jadwal_setoran' => 'pagi',
            'jenis_setoran' => 'tambah_hafalan',
            'keterangan' => 'lancar',
            'klasifikasi' => 'tercapai',
            'hadir' => 1,
        ]);
    }

    public function test_guru_can_update_memorization_entry()
    {
        $entry = MemorizationEntry::factory()->forGuru($this->guruUser->id)->create([
            'juz_number' => 1,
            'surah_id' => $this->surah->id,
            'halaman' => 10,
            'ayat' => 5,
            'jadwal_setoran' => 'pagi',
            'keterangan' => 'lancar',
            'klasifikasi' => 'tercapai',
            'jenis_setoran' => 'tambah_hafalan',
            'notes' => 'Original notes',
        ]);

        $updateData = [
            'juz_number' => 2,
            'surah_id' => $this->surah->id,
            'halaman' => 20,
            'ayat' => 15,
            'jadwal_setoran' => 'siang',
            'keterangan' => 'tidak_lancar',
            'klasifikasi' => 'tidak_tercapai',
            'jenis_setoran' => 'murojaah_qorib',
            'hadir' => true,
            'has_violation' => true,
            'violations' => [$this->violation->id],
            'notes' => 'Updated notes',
        ];

        $response = $this->actingAs($this->guruUser)->put("/guru/setoran/{$entry->id}", $updateData);

        $response->assertStatus(302); // Redirect after success

        // Refresh the entry to get latest data
        $entry->refresh();

        // Assert the entry was updated correctly
        $this->assertEquals(2, $entry->juz_number);
        $this->assertEquals($this->surah->id, $entry->surah_id);
        $this->assertEquals(20, $entry->halaman);
        $this->assertEquals(15, $entry->ayat);
        $this->assertEquals('siang', $entry->jadwal_setoran);
        $this->assertEquals('tidak_lancar', $entry->keterangan);
        $this->assertEquals('tidak_tercapai', $entry->klasifikasi);
        $this->assertEquals('murojaah_qorib', $entry->jenis_setoran);
        $this->assertEquals('Updated notes', $entry->notes);
    }

    public function test_guru_can_delete_memorization_entry()
    {
        $entry = MemorizationEntry::factory()->forGuru($this->guruUser->id)->create();

        $response = $this->actingAs($this->guruUser)->delete("/guru/setoran/{$entry->id}");

        $response->assertStatus(302); // Redirect after success
        $this->assertSoftDeleted('memorization_entries', [
            'id' => $entry->id,
        ]);
    }
}
