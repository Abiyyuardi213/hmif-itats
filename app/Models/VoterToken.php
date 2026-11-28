<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoterToken extends Model
{
    protected $fillable = [
        'election_id',
        'eligible_voter_id',
        'token_hash',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function eligibleVoter(): BelongsTo
    {
        return $this->belongsTo(EligibleVoter::class);
    }

    public function isUsable(): bool
    {
        return $this->used_at === null
            && $this->expires_at !== null
            && $this->expires_at->isFuture();
    }
}
