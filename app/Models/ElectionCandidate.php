<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ElectionCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'candidate_number',
        'ketua_name',
        'wakil_name',
        'tagline',
        'vision_mission',
        'photo_path',
    ];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'candidate_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        if (! $this->photo_path) {
            return asset('image/default-avatar.svg');
        }

        if (str_starts_with($this->photo_path, 'image/')) {
            return asset($this->photo_path);
        }

        return Storage::disk('public')->url($this->photo_path);
    }
}
