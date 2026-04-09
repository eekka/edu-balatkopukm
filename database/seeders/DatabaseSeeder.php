<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin Akademi',
            'email' => 'admin@akademi.test',
            'username' => 'admin',
            'role' => 'admin',
            'instansi' => 'Akademi Balatkop UKM',
            'no_hp' => '08123456789',
            'password' => bcrypt('password123'),
        ]);

        // Create mentor user
        $mentor = User::factory()->create([
            'name' => 'Mentor Budi',
            'email' => 'mentor@akademi.test',
            'username' => 'mentor_budi',
            'role' => 'mentor',
            'instansi' => 'Akademi Balatkop UKM',
            'no_hp' => '08223456789',
            'password' => bcrypt('password123'),
        ]);

        // Create peserta user
        $peserta = User::factory()->create([
            'name' => 'Peserta Ahmad',
            'email' => 'peserta@akademi.test',
            'username' => 'peserta_ahmad',
            'role' => 'peserta',
            'instansi' => 'PT ABC',
            'no_hp' => '08323456789',
            'password' => bcrypt('password123'),
        ]);

        // Create programs
        $program1 = Program::create([
            'nama' => 'Leadership & Management',
            'deskripsi' => 'Program pelatihan kepemimpinan dan manajemen untuk pengembangan karir profesional.',
            'icon' => 'briefcase',
        ]);

        $program2 = Program::create([
            'nama' => 'Digital Skills',
            'deskripsi' => 'Program pengembangan keterampilan digital dan teknologi informasi modern.',
            'icon' => 'computer',
        ]);

        // Create classes under program 1
        $kelas1 = Kelas::create([
            'program_id' => $program1->id,
            'nama' => 'Leadership Fundamentals',
            'deskripsi' => 'Dasar-dasar kepemimpinan yang efektif untuk manajer muda',
            'mentor_id' => $mentor->id,
            'mulai' => now()->addDay(),
            'selesai' => now()->addDays(30),
            'kapasitas' => 30,
            'peserta_terdaftar' => 1,
            'status' => 'aktif',
        ]);

        // Create class under program 2
        $kelas2 = Kelas::create([
            'program_id' => $program2->id,
            'nama' => 'Excel & Data Analysis',
            'deskripsi' => 'Topik excel advanced untuk analisis data bisnis',
            'mentor_id' => $mentor->id,
            'mulai' => now()->addDays(5),
            'selesai' => now()->addDays(35),
            'kapasitas' => 25,
            'peserta_terdaftar' => 1,
            'status' => 'draft',
        ]);

        // Enroll peserta to classes
        $kelas1->enrollments()->create([
            'peserta_id' => $peserta->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);

        $kelas2->enrollments()->create([
            'peserta_id' => $peserta->id,
            'terdaftar_pada' => now(),
            'status' => 'aktif',
        ]);
    }
}
