<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\KelasEnrollment;
use App\Models\Materi;
use App\Models\Program;
use App\Models\Quiz;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_can_manually_replace_mentor_and_participants_when_editing_kelas(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $mentorAwal = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $mentorBaru = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $pesertaA = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $pesertaB = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $pesertaC = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);

        $program = Program::create([
            'nama' => 'Program Operasional',
            'deskripsi' => 'Program untuk pengujian admin.',
        ]);

        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Kelas Uji Admin',
            'deskripsi' => 'Kelas awal sebelum diedit.',
            'mentor_id' => $mentorAwal->id,
            'kapasitas' => 30,
            'peserta_terdaftar' => 2,
            'status' => 'aktif',
        ]);

        $kelas->enrollments()->createMany([
            [
                'peserta_id' => $pesertaA->id,
                'terdaftar_pada' => now(),
                'status' => 'aktif',
            ],
            [
                'peserta_id' => $pesertaB->id,
                'terdaftar_pada' => now(),
                'status' => 'aktif',
            ],
        ]);

        $this->actingAs($admin)
            ->put(route('admin.kelas.update', $kelas), [
                'program_id' => $program->id,
                'nama' => 'Kelas Uji Admin',
                'deskripsi' => 'Kelas setelah diubah admin.',
                'mentor_id' => $mentorBaru->id,
                'kapasitas' => 30,
                'status' => 'aktif',
                'peserta_ids' => [$pesertaB->id, $pesertaC->id],
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('kelas', [
            'id' => $kelas->id,
            'mentor_id' => $mentorBaru->id,
            'peserta_terdaftar' => 2,
        ]);

        $this->assertDatabaseMissing('kelas_enrollments', [
            'kelas_id' => $kelas->id,
            'peserta_id' => $pesertaA->id,
        ]);

        $this->assertDatabaseHas('kelas_enrollments', [
            'kelas_id' => $kelas->id,
            'peserta_id' => $pesertaB->id,
            'status' => 'aktif',
        ]);

        $this->assertDatabaseHas('kelas_enrollments', [
            'kelas_id' => $kelas->id,
            'peserta_id' => $pesertaC->id,
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_create_kelas_with_recurring_schedule(): void
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
            'nama' => 'Program Desain',
            'deskripsi' => 'Program desain dasar.',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.kelas.store'), [
                'program_id' => $program->id,
                'nama' => 'Desain Dasar',
                'deskripsi' => 'Kelas desain dasar mingguan.',
                'jadwal_hari' => 'kamis',
                'jadwal_jam' => '09:00',
                'mentor_id' => $mentor->id,
                'kapasitas' => 20,
                'status' => 'aktif',
                'peserta_ids' => [],
            ])
            ->assertSessionHas('status');

        $kelas = Kelas::where('nama', 'Desain Dasar')->firstOrFail();

        $this->assertSame('kamis', $kelas->jadwal_hari);
        $this->assertSame('09:00', Carbon::parse($kelas->jadwal_jam)->format('H:i'));
        $this->assertSame($mentor->id, $kelas->mentor_id);
    }

    public function test_peserta_can_see_kelas_schedule_in_dashboard_and_schedule_page(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Desain',
            'deskripsi' => 'Program desain dasar.',
        ]);
        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Desain Dasar',
            'deskripsi' => 'Kelas desain dasar mingguan.',
            'jadwal_hari' => 'kamis',
            'jadwal_jam' => '09:00',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        KelasEnrollment::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        $this->actingAs($peserta)
            ->get(route('peserta.dashboard'))
            ->assertOk()
            ->assertSee('Timeline')
            ->assertSee('Calendar');

        $this->actingAs($peserta)
            ->get(route('peserta.jadwal'))
            ->assertOk()
            ->assertSee('Kamis')
            ->assertSee('09:00');

        $this->actingAs($peserta)
            ->get(route('peserta.kelas.show', $kelas))
            ->assertOk()
            ->assertSee('Jadwal')
            ->assertSee('Kamis')
            ->assertSee('09:00');
    }

    public function test_peserta_can_submit_tugas_and_see_submission_status(): void
    {
        Storage::fake('public');

        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Desain',
            'deskripsi' => 'Program desain dasar.',
        ]);
        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Desain Dasar',
            'deskripsi' => 'Kelas desain dasar mingguan.',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        KelasEnrollment::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        $tugas = Tugas::create([
            'kelas_id' => $kelas->id,
            'judul' => 'Tugas Portofolio',
            'deskripsi' => 'Kumpulkan hasil kerja dalam format PDF.',
            'deadline' => now()->addDays(5),
            'nilai_maksimal' => 100,
            'status' => 'aktif',
        ]);

        $file = UploadedFile::fake()->create('jawaban.pdf', 120, 'application/pdf');

        $this->actingAs($peserta)
            ->post(route('peserta.kelas.tugas.submit', [$kelas, $tugas]), [
                'file' => $file,
                'komentar' => 'Silakan diperiksa, mentor.',
            ])
            ->assertSessionHas('status');

        $submission = TugasSubmission::firstOrFail();

        Storage::disk('public')->assertExists($submission->file);

        $this->assertDatabaseHas('tugas_submissions', [
            'tugas_id' => $tugas->id,
            'peserta_id' => $peserta->id,
        ]);

        $this->actingAs($peserta)
            ->get(route('peserta.kelas.show', $kelas))
            ->assertOk()
            ->assertSee('Status Pengumpulan')
            ->assertSee('Sudah dikumpulkan');
    }

    public function test_peserta_can_filter_schedule_by_day(): void
    {
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Desain',
            'deskripsi' => 'Program desain dasar.',
        ]);

        $kelasRabu = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Desain Rabu',
            'deskripsi' => 'Kelas desain hari Rabu.',
            'jadwal_hari' => 'rabu',
            'jadwal_jam' => '09:00',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        $kelasKamis = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Desain Kamis',
            'deskripsi' => 'Kelas desain hari Kamis.',
            'jadwal_hari' => 'kamis',
            'jadwal_jam' => '10:00',
            'mentor_id' => $mentor->id,
            'kapasitas' => 20,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        KelasEnrollment::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelasRabu->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        KelasEnrollment::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelasKamis->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        $this->actingAs($peserta)
            ->get(route('peserta.jadwal', ['hari' => 'rabu']))
            ->assertOk()
            ->assertSee('Kelas Hari Rabu')
            ->assertSee('Desain Rabu')
            ->assertDontSee('Desain Kamis');
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

    public function test_mentor_can_add_materi_tugas_quiz_and_diskusi_and_peserta_can_access_them(): void
    {
        Storage::fake('public');

        $mentor = User::factory()->create([
            'role' => 'mentor',
            'email_verified_at' => now(),
        ]);
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'email_verified_at' => now(),
        ]);
        $program = Program::create([
            'nama' => 'Program Manajemen',
            'deskripsi' => 'Program manajemen kelas.',
        ]);
        $kelas = Kelas::create([
            'program_id' => $program->id,
            'nama' => 'Kelas Konten Mentor',
            'deskripsi' => 'Kelas untuk uji konten mentor.',
            'mentor_id' => $mentor->id,
            'kapasitas' => 30,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        KelasEnrollment::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        $pptFile = UploadedFile::fake()->create('slide-materi.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $this->actingAs($mentor)
            ->post(route('mentor.kelas.materi.store', $kelas), [
                'judul' => 'Materi Pengantar',
                'isi' => 'Konten materi pengantar kelas.',
                'pertemuan' => 1,
                'tipe' => 'ppt',
                'url' => null,
                'file' => $pptFile,
            ])
            ->assertSessionHas('status');

        $this->actingAs($mentor)
            ->post(route('mentor.kelas.tugas.store', $kelas), [
                'judul' => 'Tugas Minggu 1',
                'deskripsi' => 'Kerjakan studi kasus dasar.',
                'deadline' => now()->addDays(7)->format('Y-m-d H:i:s'),
                'nilai_maksimal' => 100,
                'status' => 'aktif',
            ])
            ->assertSessionHas('status');

        $this->actingAs($mentor)
            ->post(route('mentor.kelas.quiz.store', $kelas), [
                'judul' => 'Quiz Dasar',
                'deskripsi' => 'Quiz pemahaman awal.',
                'waktu_pengerjaan' => 45,
                'nilai_maksimal' => 100,
                'mulai' => now()->format('Y-m-d H:i:s'),
                'selesai' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'status' => 'aktif',
            ])
            ->assertSessionHas('status');

        $this->actingAs($mentor)
            ->post(route('mentor.kelas.diskusi.store', $kelas), [
                'topik' => 'Strategi Komunikasi',
                'isi' => 'Bagikan pendapat Anda tentang strategi komunikasi efektif.',
                'pertemuan' => 1,
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas((new Materi)->getTable(), [
            'kelas_id' => $kelas->id,
            'judul' => 'Materi Pengantar',
        ]);

        $materi = Materi::where('kelas_id', $kelas->id)->where('judul', 'Materi Pengantar')->firstOrFail();
        Storage::disk('public')->assertExists($materi->file);

        $this->assertDatabaseHas((new Tugas)->getTable(), [
            'kelas_id' => $kelas->id,
            'judul' => 'Tugas Minggu 1',
        ]);
        $this->assertDatabaseHas((new Quiz)->getTable(), [
            'kelas_id' => $kelas->id,
            'judul' => 'Quiz Dasar',
        ]);
        $this->assertDatabaseHas((new Materi)->getTable(), [
            'kelas_id' => $kelas->id,
            'judul' => 'Diskusi: Strategi Komunikasi',
        ]);

        $this->actingAs($peserta)
            ->get(route('peserta.kelas.show', $kelas))
            ->assertOk()
            ->assertSee('Materi Pengantar')
            ->assertSee('Materi Pembelajaran')
            ->assertSee('Diskusi Kelas')
            ->assertSee('Pengumpulan Tugas')
            ->assertSee('Buka File')
            ->assertSee('Tugas Minggu 1')
            ->assertSee('Quiz Dasar')
            ->assertSee('Strategi Komunikasi');
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
