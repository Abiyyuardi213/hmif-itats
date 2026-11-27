<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EligibleVoter extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'identifier_hash',
        'identifier_masked',
        'voter_name',
        'voter_type',
        'email',
        'has_voted',
        'voted_at',
    ];

    protected function casts(): array
    {
        return [
            'has_voted' => 'boolean',
            'voted_at' => 'datetime',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(VoterToken::class);
    }
}
