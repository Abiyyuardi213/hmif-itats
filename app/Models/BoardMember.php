<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BoardMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'division_id',
        'name',
        'position',
        'is_core',
        'photo_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_core' => 'boolean',
        ];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
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
