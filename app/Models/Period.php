<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cabinet_name',
        'tagline',
        'vision',
        'mission',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'mission' => 'array',
            'is_active' => 'boolean',
            'starts_at' => 'date',
            'ends_at' => 'date',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function current(): ?self
    {
        return static::query()->active()->latest('id')->first()
            ?? static::query()->latest('id')->first();
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class)->orderBy('sort_order');
    }

    public function boardMembers(): HasMany
    {
        return $this->hasMany(BoardMember::class)->orderBy('sort_order');
    }

    public function workPrograms(): HasMany
    {
        return $this->hasMany(WorkProgram::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }
}
