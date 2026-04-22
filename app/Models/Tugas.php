<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'file_soal',
        'deadline',
        'nilai_maksimal',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'jenis', 'id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TugasSubmission::class);
    }
}
