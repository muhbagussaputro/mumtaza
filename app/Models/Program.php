<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'jenis',
        'guru_id',
        'deskripsi',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function juzTargets(): HasMany
    {
        return $this->hasMany(JuzTarget::class);
    }

    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_programs', 'program_id', 'student_id')
            ->withPivot(['started_at', 'finished_at', 'progress_cached'])
            ->withTimestamps();
    }

    public function memorizationEntries(): HasMany
    {
        return $this->hasMany(MemorizationEntry::class);
    }

    // Scope untuk jenis program
    public function scopeReguler($query)
    {
        return $query->where('jenis', 'reguler');
    }

    public function scopeKhusus($query)
    {
        return $query->where('jenis', 'khusus');
    }
}
