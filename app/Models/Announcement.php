<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'judul',
        'isi',
        'image_path',
        'target',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targetedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'announcement_user')->withTimestamps();
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $visibleQuery) use ($user): void {
            $visibleQuery->whereHas('targetedUsers', function (Builder $targetedQuery) use ($user): void {
                $targetedQuery->where('users.id', $user->id);
            })->orWhere(function (Builder $publicQuery) use ($user): void {
                $publicQuery->whereDoesntHave('targetedUsers')
                    ->whereIn('target', ['all', $user->role]);
            });
        });
    }
}
