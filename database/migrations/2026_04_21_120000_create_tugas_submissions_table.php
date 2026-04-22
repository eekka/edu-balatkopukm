<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->foreignId('peserta_id')->constrained('users')->cascadeOnDelete();
            $table->string('file');
            $table->text('komentar')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['tugas_id', 'peserta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_submissions');
    }
};
