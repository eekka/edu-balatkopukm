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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'mentor', 'peserta'])->default('peserta')->after('email');
            $table->string('username')->unique()->nullable()->after('role');
            $table->string('foto_profil')->nullable()->after('username');
            $table->string('instansi')->nullable()->after('foto_profil');
            $table->string('no_hp')->nullable()->after('instansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'username', 'foto_profil', 'instansi', 'no_hp']);
        });
    }
};
