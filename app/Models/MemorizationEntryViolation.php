<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemorizationEntryViolation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'entry_id',
        'violation_id',
    ];

    public function memorizationEntry(): BelongsTo
    {
        return $this->belongsTo(MemorizationEntry::class, 'entry_id');
    }

    public function violation(): BelongsTo
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }
}
