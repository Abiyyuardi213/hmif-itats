<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_OPEN = 'open';

    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_OPEN => 'Dibuka',
        self::STATUS_CLOSED => 'Ditutup',
    ];

    protected $fillable = [
        'period_id',
        'title',
        'slug',
        'description',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(ElectionCandidate::class)->orderBy('candidate_number');
    }

    public function eligibleVoters(): HasMany
    {
        return $this->hasMany(EligibleVoter::class);
    }

    public function voterTokens(): HasMany
    {
        return $this->hasMany(VoterToken::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function isCurrentlyOpen(): bool
    {
        return $this->status === self::STATUS_OPEN
            && $this->starts_at !== null
            && $this->ends_at !== null
            && now()->betweenIncluded($this->starts_at, $this->ends_at);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
