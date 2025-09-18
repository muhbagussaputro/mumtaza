<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramJuzTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'juz_number',
    ];

    protected $casts = [
        'juz_number' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
