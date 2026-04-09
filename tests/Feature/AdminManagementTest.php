<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_management_pages(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.programs.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.kelas.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.announcements.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.reports.index'))
            ->assertOk();
    }

    public function test_admin_can_create_program_and_announcement(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.programs.store'), [
                'nama' => 'Pelatihan Digital Marketing',
                'deskripsi' => 'Program marketing digital',
                'icon' => 'chart-line',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('programs', [
            'nama' => 'Pelatihan Digital Marketing',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.announcements.store'), [
                'judul' => 'Jadwal Pelatihan Baru',
                'isi' => 'Pelatihan dimulai Senin depan.',
                'target' => 'all',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('announcements', [
            'judul' => 'Jadwal Pelatihan Baru',
        ]);
    }

    public function test_admin_can_create_and_reset_user_password(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Mentor Baru',
                'email' => 'mentor.baru@example.com',
                'username' => 'mentor_baru',
                'password' => 'password123',
                'role' => 'mentor',
            ])
            ->assertSessionHas('status');

        $user = User::where('email', 'mentor.baru@example.com')->firstOrFail();

        $this->assertTrue(Hash::check('password123', $user->password));

        $this->actingAs($admin)
            ->post(route('admin.users.reset-password', $user))
            ->assertSessionHas('status');

        $user->refresh();

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_non_admin_cannot_access_admin_pages(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($mentor)
            ->get(route('admin.users.index'))
            ->assertStatus(403);
    }
}
