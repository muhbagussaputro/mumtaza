<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Program;
use App\Models\JuzTarget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);
        
        // Seed basic data
        $this->seed([
            \Database\Seeders\SurahSeeder::class,
        ]);
    }

    public function test_admin_can_view_programs_index()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('admin.programs.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.programs.index');
    }

    public function test_admin_can_view_create_program_form()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('admin.programs.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.programs.create');
    }

    public function test_admin_can_create_program()
    {
        $this->actingAs($this->admin);
        
        $programData = [
            'nama' => 'Program Test',
            'deskripsi' => 'Deskripsi program test',
            'jenis' => 'reguler',
            'guru_id' => $this->admin->id,
            'juz_targets' => [1, 2, 3]
        ];
        
        $response = $this->post(route('admin.programs.store'), $programData);
        
        $response->assertRedirect(route('admin.programs.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('programs', [
            'nama' => 'Program Test',
            'deskripsi' => 'Deskripsi program test',
            'jenis' => 'reguler'
        ]);
        
        // Check juz targets are created
        $program = Program::where('nama', 'Program Test')->first();
        $this->assertCount(3, $program->juzTargets);
    }

    public function test_admin_can_view_program_details()
    {
        $this->actingAs($this->admin);
        
        $program = Program::factory()->create([
            'nama' => 'Test Program',
            'guru_id' => $this->admin->id
        ]);
        
        $response = $this->get(route('admin.programs.show', $program));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.programs.show');
        $response->assertViewHas('program');
        $response->assertSee('Test Program');
    }

    public function test_admin_can_view_edit_program_form()
    {
        $this->actingAs($this->admin);
        
        $program = Program::factory()->create([
            'guru_id' => $this->admin->id
        ]);
        
        $response = $this->get(route('admin.programs.edit', $program));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.programs.edit');
        $response->assertViewHas('program');
    }

    public function test_admin_can_update_program()
    {
        $this->actingAs($this->admin);
        
        $program = Program::factory()->create([
            'nama' => 'Original Name',
            'guru_id' => $this->admin->id
        ]);
        
        $updateData = [
            'nama' => 'Updated Name',
            'deskripsi' => 'Updated description',
            'jenis' => 'khusus',
            'guru_id' => $this->admin->id,
            'juz_targets' => [4, 5, 6]
        ];
        
        $response = $this->put(route('admin.programs.update', $program), $updateData);

        $response->assertRedirect(route('admin.programs.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'nama' => 'Updated Name',
            'deskripsi' => 'Updated description',
            'jenis' => 'khusus'
        ]);
    }

    public function test_admin_can_delete_program()
    {
        $this->actingAs($this->admin);
        
        $program = Program::factory()->create([
            'guru_id' => $this->admin->id
        ]);
        
        $response = $this->delete(route('admin.programs.destroy', $program));
        
        $response->assertRedirect(route('admin.programs.index'));
        $response->assertSessionHas('success');
        
        $this->assertSoftDeleted('programs', [
            'id' => $program->id
        ]);
    }

    public function test_admin_can_restore_program()
    {
        $this->actingAs($this->admin);
        
        $program = Program::factory()->create([
            'guru_id' => $this->admin->id
        ]);
        
        // Delete the program first
        $program->delete();
        
        $response = $this->post(route('admin.programs.restore', $program->id));
        
        $response->assertRedirect(route('admin.programs.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'deleted_at' => null
        ]);
    }

    public function test_program_validation_requires_nama()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.programs.store'), [
            'deskripsi' => 'Test description',
            'jenis' => 'reguler'
        ]);
        
        $response->assertSessionHasErrors('nama');
    }

    public function test_program_validation_requires_valid_jenis()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.programs.store'), [
            'nama' => 'Test Program',
            'jenis' => 'invalid_type'
        ]);
        
        $response->assertSessionHasErrors('jenis');
    }

    public function test_non_admin_cannot_access_program_management()
    {
        $user = User::factory()->create(['role' => 'siswa']);
        $this->actingAs($user);
        
        $response = $this->get(route('admin.programs.index'));
        
        $response->assertStatus(403);
    }
}