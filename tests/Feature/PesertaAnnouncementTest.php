<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesertaAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_can_view_announcements_page(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        Announcement::create([
            'created_by' => $peserta->id,
            'judul' => 'Info Peserta',
            'isi' => 'Pengumuman khusus peserta.',
            'target' => 'peserta',
            'published_at' => now(),
        ]);

        Announcement::create([
            'created_by' => $peserta->id,
            'judul' => 'Info Umum',
            'isi' => 'Pengumuman untuk semua pengguna.',
            'target' => 'all',
            'published_at' => now(),
        ]);

        Announcement::create([
            'created_by' => $peserta->id,
            'judul' => 'Info Mentor',
            'isi' => 'Pengumuman untuk mentor saja.',
            'target' => 'mentor',
            'published_at' => now(),
        ]);

        $this->actingAs($peserta)
            ->get(route('peserta.announcements.index'))
            ->assertOk()
            ->assertSee('Pengumuman')
            ->assertSee('Info Peserta')
            ->assertSee('Info Umum')
            ->assertDontSee('Info Mentor');
    }

    public function test_only_selected_peserta_can_access_targeted_announcement(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $selectedPeserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $nonSelectedPeserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        $announcement = Announcement::create([
            'created_by' => $admin->id,
            'judul' => 'Info Khusus',
            'isi' => 'Hanya peserta yang dipilih admin yang bisa lihat.',
            'target' => 'all',
            'published_at' => now(),
        ]);

        $announcement->targetedUsers()->attach($selectedPeserta->id);

        $this->actingAs($selectedPeserta)
            ->get(route('peserta.announcements.index'))
            ->assertOk()
            ->assertSee('Info Khusus');

        $this->actingAs($nonSelectedPeserta)
            ->get(route('peserta.announcements.index'))
            ->assertOk()
            ->assertDontSee('Info Khusus');
    }
}
