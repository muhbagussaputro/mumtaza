<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemorizationProgramItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'juz_number',
        'title',
        'target_date',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'target_date' => 'date',
        'completed_at' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(MemorizationProgram::class, 'program_id');
    }
}
