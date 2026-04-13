<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kelas extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Kelas $kelas): void {
            if (! $kelas->kode_kelas) {
                $kelas->kode_kelas = self::generateKodeKelas();
            }
        });
    }

    protected $table = 'kelas';

    protected $fillable = [
        'program_id',
        'nama',
        'kode_kelas',
        'deskripsi',
        'mentor_id',
        'mulai',
        'selesai',
        'kapasitas',
        'peserta_terdaftar',
        'status',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(KelasEnrollment::class);
    }

    public function peserta(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'kelas_enrollments', 'kelas_id', 'peserta_id')
            ->withTimestamps();
    }

    public static function generateKodeKelas(): string
    {
        do {
            $kodeKelas = Str::upper(Str::random(8));
        } while (self::where('kode_kelas', $kodeKelas)->exists());

        return $kodeKelas;
    }
}
