<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nisn',
        'nis',
        'foto_profil',
        'email',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_orang_tua',
        'id_kelas',
        'jenis',
        'tahun_masuk',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
        'jenis' => 'string',
        'status' => 'string',
    ];

    protected $dates = [
        'deleted_at',
    ];

    // Validation rules
    public static function validationRules($id = null)
    {
        return [
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:siswas,nisn'.($id ? ",$id" : ''),
            'nis' => 'required|string|max:20|unique:siswas,nis'.($id ? ",$id" : ''),
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:siswas,email'.($id ? ",$id" : ''),
            'telepon' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'required|string|max:255',
            'id_kelas' => 'required|exists:classes,id',
            'jenis' => 'required|in:regular,khusus',
            'tahun_masuk' => 'required|integer|min:2000|max:'.(date('Y') + 1),
            'status' => 'required|in:active,inactive,graduated',
        ];
    }

    // Validation messages
    public static function validationMessages()
    {
        return [
            'nama.required' => 'Nama siswa wajib diisi.',
            'nama.string' => 'Nama siswa harus berupa teks.',
            'nama.max' => 'Nama siswa maksimal 255 karakter.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.string' => 'NISN harus berupa teks.',
            'nisn.max' => 'NISN maksimal 20 karakter.',
            'nisn.unique' => 'NISN sudah digunakan.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.string' => 'NIS harus berupa teks.',
            'nis.max' => 'NIS maksimal 20 karakter.',
            'nis.unique' => 'NIS sudah digunakan.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'telepon.string' => 'Nomor telepon harus berupa teks.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'nama_orang_tua.required' => 'Nama orang tua wajib diisi.',
            'nama_orang_tua.string' => 'Nama orang tua harus berupa teks.',
            'nama_orang_tua.max' => 'Nama orang tua maksimal 255 karakter.',
            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'jenis.required' => 'Jenis siswa wajib dipilih.',
            'jenis.in' => 'Jenis siswa harus regular atau khusus.',
            'tahun_masuk.required' => 'Tahun masuk wajib diisi.',
            'tahun_masuk.integer' => 'Tahun masuk harus berupa angka.',
            'tahun_masuk.min' => 'Tahun masuk minimal 2000.',
            'tahun_masuk.max' => 'Tahun masuk maksimal '.(date('Y') + 1).'.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus active, inactive, atau graduated.',
        ];
    }

    // Relations
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'id_kelas');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeGraduated($query)
    {
        return $query->where('status', 'graduated');
    }

    public function scopeRegular($query)
    {
        return $query->where('jenis', 'regular');
    }

    public function scopeKhusus($query)
    {
        return $query->where('jenis', 'khusus');
    }

    // Accessors
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('storage/'.$this->foto_profil);
        }

        return asset('images/default-avatar.png');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'graduated' => 'Lulus',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getJenisLabelAttribute()
    {
        return $this->jenis === 'regular' ? 'Regular' : 'Khusus';
    }

    public function getNamaLengkapAttribute()
    {
        return $this->nama.' ('.$this->nis.')';
    }
}
