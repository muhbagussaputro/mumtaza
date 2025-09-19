<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemorizationEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'program_id',
        'guru_id',
        'juz_number',
        'surah_id',
        'halaman',
        'ayat',
        'jadwal_setoran',
        'jenis_setoran',
        'keterangan',
        'klasifikasi',
        'hadir',
        'notes',
    ];

    protected $casts = [
        'juz_number' => 'integer',
        'surah_id' => 'integer',
        'halaman' => 'integer',
        'ayat' => 'integer',
        'hadir' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function violations(): HasMany
    {
        return $this->hasMany(MemorizationEntryViolation::class, 'entry_id');
    }

    // Scope untuk jadwal setoran
    public function scopePagi($query)
    {
        return $query->where('jadwal_setoran', 'pagi');
    }

    public function scopeSiang($query)
    {
        return $query->where('jadwal_setoran', 'siang');
    }

    public function scopeMalam($query)
    {
        return $query->where('jadwal_setoran', 'malam');
    }

    // Scope untuk jenis setoran
    public function scopeTambahHafalan($query)
    {
        return $query->where('jenis_setoran', 'tambah_hafalan');
    }

    public function scopeMurojaahQorib($query)
    {
        return $query->where('jenis_setoran', 'murojaah_qorib');
    }

    public function scopeMurojaahBid($query)
    {
        return $query->where('jenis_setoran', 'murojaah_bid');
    }

    // Scope untuk klasifikasi
    public function scopeTercapai($query)
    {
        return $query->where('klasifikasi', 'tercapai');
    }

    public function scopeTidakTercapai($query)
    {
        return $query->where('klasifikasi', 'tidak_tercapai');
    }

    // Scope untuk keterangan
    public function scopeLancar($query)
    {
        return $query->where('keterangan', 'lancar');
    }

    public function scopeTidakLancar($query)
    {
        return $query->where('keterangan', 'tidak_lancar');
    }

    // Scope untuk kehadiran
    public function scopeHadir($query)
    {
        return $query->where('hadir', true);
    }

    public function scopeTidakHadir($query)
    {
        return $query->where('hadir', false);
    }
}
