<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelas_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->dateTime('terdaftar_pada');
            $table->boolean('sudah_absen')->default(false);
            $table->integer('kehadiran')->default(0);
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->boolean('sudah_sertifikat')->default(false);
            $table->unique(['peserta_id', 'kelas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_enrollments');
    }
};
