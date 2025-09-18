<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surah extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name_ar',
        'name_id',
        'name_en',
        'revelation_place',
        'ayah_count',
    ];

    public function memorizationEntries(): HasMany
    {
        return $this->hasMany(MemorizationEntry::class);
    }

    /**
     * Get all hafalan for this surah.
     */
    public function hafalan(): HasMany
    {
        return $this->hasMany(Hafalan::class, 'id_surat');
    }
}
