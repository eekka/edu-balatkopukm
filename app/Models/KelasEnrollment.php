<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KelasEnrollment extends Model
{
    use HasFactory;

    protected $table = 'kelas_enrollments';

    protected $fillable = [
        'peserta_id',
        'kelas_id',
        'terdaftar_pada',
        'sudah_absen',
        'kehadiran',
        'nilai_akhir',
        'status',
        'sudah_sertifikat',
    ];

    protected $casts = [
        'terdaftar_pada' => 'datetime',
        'sudah_absen' => 'boolean',
        'sudah_sertifikat' => 'boolean',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peserta_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}
