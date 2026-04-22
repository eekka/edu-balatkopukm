<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasSubmission extends Model
{
    use HasFactory;

    protected $table = 'tugas_submissions';

    protected $fillable = [
        'tugas_id',
        'peserta_id',
        'file',
        'komentar',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class);
    }

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peserta_id');
    }
}
