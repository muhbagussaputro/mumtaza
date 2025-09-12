<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Memorization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surah_id',
        'program_id',
        'start_ayah',
        'end_ayah',
        'memorized_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'memorized_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(MemorizationProgram::class, 'program_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(MemorizationEvaluation::class);
    }
}
