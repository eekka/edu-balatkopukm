<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_mentor_can_create_kelas_and_admin_can_edit_and_delete_it(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Kepemimpinan',
            'deskripsi' => 'Pelatihan kepemimpinan dasar.',
        ]);

        $this->actingAs($mentor)
            ->post(route('mentor.kelas.store'), [
                'program_id' => $program->id,
                'nama' => 'Kelas Mentor Baru',
                'deskripsi' => 'Dibuat langsung oleh mentor.',
                'kapasitas' => 25,
                'status' => 'aktif',
            ])
            ->assertSessionHas('status');

        $kelas = Kelas::firstOrFail();

        $this->assertDatabaseHas('kelas', [
            'id' => $kelas->id,
            'mentor_id' => $mentor->id,
            'nama' => 'Kelas Mentor Baru',
        ]);
        $this->assertNotNull($kelas->kode_kelas);

        $this->actingAs($admin)
            ->put(route('admin.kelas.update', $kelas), [
                'program_id' => $program->id,
                'nama' => 'Kelas Mentor Diperbarui Admin',
                'deskripsi' => 'Nama kelas diperbarui oleh admin.',
                'mentor_id' => $mentor->id,
                'kapasitas' => 30,
                'status' => 'aktif',
                'peserta_ids' => [],
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('kelas', [
            'id' => $kelas->id,
            'nama' => 'Kelas Mentor Diperbarui Admin',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.kelas.destroy', $kelas))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('kelas', [
            'id' => $kelas->id,
        ]);
    }

    public function test_mentor_can_view_kelas_index_page(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($mentor)
            ->get(route('mentor.kelas.index'))
            ->assertStatus(200)
            ->assertSee('Kelas Saya');
    }

    public function test_mentor_can_view_create_kelas_page(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($mentor)
            ->get(route('mentor.kelas.create'))
            ->assertStatus(200)
            ->assertSee('Buat Kelas Baru');
    }

    public function test_mentor_can_view_kelas_show_page(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Public Speaking',
            'deskripsi' => 'Pelatihan berbicara di depan umum.',
        ]);
        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Kelas Public Speaking',
            'deskripsi' => 'Kelas untuk peserta baru.',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 0,
            'status' => 'aktif',
        ]);

        $this->actingAs($mentor)
            ->get(route('mentor.kelas.show', $kelas))
            ->assertStatus(200)
            ->assertSee('Detail Kelas')
            ->assertSee('Kelas Public Speaking');
    }

    public function test_peserta_can_join_kelas_using_valid_code(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Public Speaking',
            'deskripsi' => 'Pelatihan berbicara di depan umum.',
        ]);
        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Kelas Public Speaking',
            'deskripsi' => 'Kelas untuk peserta baru.',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 0,
            'status' => 'aktif',
        ]);

        $this->actingAs($peserta)
            ->post(route('peserta.kelas.join'), [
                'kode_kelas' => strtolower($kelas->kode_kelas),
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('kelas_enrollments', [
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
            'status' => 'aktif',
        ]);
    }

    public function test_peserta_cannot_join_kelas_using_invalid_code(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($peserta)
            ->post(route('peserta.kelas.join'), [
                'kode_kelas' => 'TIDAKADA',
            ])
            ->assertSessionHasErrors('kode_kelas');

        $this->assertDatabaseCount('kelas_enrollments', 0);
    }
}
