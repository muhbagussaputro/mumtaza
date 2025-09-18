<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hafalan extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'hafalan';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_program_siswa',
        'waktu',
        'kehadiran',
        'id_surat',
        'ayat_mulai',
        'ayat_selesai',
        'jenis_hafalan',
        'target',
        'keterangan',
        'komentar',
        'pelanggaran',
        'ket_pelanggaran',
        'halaman',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the student program that owns the hafalan.
     */
    public function studentProgram(): BelongsTo
    {
        return $this->belongsTo(StudentProgram::class, 'id_program_siswa');
    }

    /**
     * Get the surah that owns the hafalan.
     */
    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'id_surat');
    }

    /**
     * Scope untuk filter berdasarkan waktu
     */
    public function scopeByWaktu($query, $waktu)
    {
        return $query->where('waktu', $waktu);
    }

    /**
     * Scope untuk filter berdasarkan target
     */
    public function scopeByTarget($query, $target)
    {
        return $query->where('target', $target);
    }

    /**
     * Scope untuk filter berdasarkan jenis hafalan
     */
    public function scopeByJenisHafalan($query, $jenis)
    {
        return $query->where('jenis_hafalan', $jenis);
    }

    /**
     * Accessor untuk mendapatkan nama surah
     */
    public function getNamaSurahAttribute()
    {
        return $this->surah ? $this->surah->name_id : null;
    }

    /**
     * Accessor untuk mendapatkan nama siswa
     */
    public function getNamaSiswaAttribute()
    {
        return $this->studentProgram && $this->studentProgram->student
            ? $this->studentProgram->student->name
            : null;
    }
}
