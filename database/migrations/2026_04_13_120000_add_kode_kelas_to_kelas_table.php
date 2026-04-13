<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('kode_kelas', 20)->nullable()->unique()->after('nama');
        });

        $kelasIds = DB::table('kelas')
            ->whereNull('kode_kelas')
            ->pluck('id');

        foreach ($kelasIds as $kelasId) {
            do {
                $kodeKelas = Str::upper(Str::random(8));
            } while (DB::table('kelas')->where('kode_kelas', $kodeKelas)->exists());

            DB::table('kelas')
                ->where('id', $kelasId)
                ->update(['kode_kelas' => $kodeKelas]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropUnique('kelas_kode_kelas_unique');
            $table->dropColumn('kode_kelas');
        });
    }
};
