<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('landing');
    }

    public function test_admin_dashboard_access(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirectToRoute('admin.dashboard');

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertSeeText('Timeline');
        $response->assertSeeText('Calendar');
        $response->assertDontSeeText('Pengguna Baru');
    }

    public function test_mentor_dashboard_access(): void
    {
        $user = User::factory()->create(['role' => 'mentor']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirectToRoute('mentor.dashboard');

        $response = $this->actingAs($user)->get('/mentor/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('mentor.dashboard');
        $response->assertSeeText('Timeline');
        $response->assertSeeText('Calendar');
    }

    public function test_peserta_dashboard_access(): void
    {
        $user = User::factory()->create(['role' => 'peserta']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirectToRoute('peserta.dashboard');

        $response = $this->actingAs($user)->get('/peserta/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('peserta.dashboard');
        $response->assertSeeText('Timeline');
        $response->assertSeeText('Calendar');
    }

    public function test_role_middleware_prevents_unauthorized_access(): void
    {
        $mentor = User::factory()->create(['role' => 'mentor']);

        $response = $this->actingAs($mentor)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirectToRoute('login');
    }
}
