<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'work_program_id',
        'title',
        'slug',
        'category',
        'event_date',
        'location',
        'summary',
        'content',
        'cover_image',
        'registration_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function workProgram(): BelongsTo
    {
        return $this->belongsTo(WorkProgram::class);
    }

    public function getCoverUrlAttribute(): string
    {
        if (! $this->cover_image) {
            return asset('image/hmif-pmo.jpg');
        }

        if (str_starts_with($this->cover_image, 'image/')) {
            return asset($this->cover_image);
        }

        return Storage::disk('public')->url($this->cover_image);
    }
}
