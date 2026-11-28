<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'code',
        'name',
        'slug',
        'short_description',
        'description',
        'sort_order',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(BoardMember::class)->orderBy('sort_order');
    }

    public function workPrograms(): HasMany
    {
        return $this->hasMany(WorkProgram::class);
    }
}
