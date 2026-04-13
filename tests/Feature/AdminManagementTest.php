<?php

namespace Tests\Feature;

use App\Models\Testimonial;
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
            ->get(route('admin.testimonials.index'))
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

    public function test_peserta_can_create_testimonial(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($peserta)
            ->post(route('peserta.testimonials.store'), [
                'rating' => 5,
                'isi' => 'Programnya sangat membantu untuk pengembangan skill saya.',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('testimonials', [
            'user_id' => $peserta->id,
            'rating' => 5,
            'isi' => 'Programnya sangat membantu untuk pengembangan skill saya.',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Programnya sangat membantu untuk pengembangan skill saya.');
    }

    public function test_admin_can_update_and_delete_testimonial(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        $testimonial = Testimonial::factory()->for($peserta)->create([
            'rating' => 4,
            'isi' => 'Awalnya cukup membantu.',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.testimonials.update', $testimonial), [
                'rating' => 5,
                'isi' => 'Testimoni sudah diperbarui oleh admin.',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'rating' => 5,
            'isi' => 'Testimoni sudah diperbarui oleh admin.',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.testimonials.destroy', $testimonial))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('testimonials', [
            'id' => $testimonial->id,
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

    public function test_non_admin_cannot_access_admin_testimonials_page(): void
    {
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($mentor)
            ->get(route('admin.testimonials.index'))
            ->assertStatus(403);
    }
}
