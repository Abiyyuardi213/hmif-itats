<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkProgram extends Model
{
    use HasFactory;

    public const STATUSES = [
        'planned' => 'Direncanakan',
        'in_progress' => 'Berjalan',
        'completed' => 'Terlaksana',
    ];

    protected $fillable = [
        'period_id',
        'division_id',
        'title',
        'slug',
        'description',
        'status',
        'target_date',
        'realized_at',
        'target_participants',
    ];

    protected function casts(): array
    {
        return [
            'target_date' => 'date',
            'realized_at' => 'date',
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

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
