<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemorizationEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorization_id',
        'evaluator_id',
        'evaluated_at',
        'accuracy_score',
        'tajwid_score',
        'fluency_score',
        'memorization_score',
        'overall_score',
        'mistake_count',
        'remarks',
        'result',
    ];

    protected $casts = [
        'evaluated_at' => 'date',
    ];

    public function memorization(): BelongsTo
    {
        return $this->belongsTo(Memorization::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
