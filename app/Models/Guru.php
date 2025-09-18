<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gurus';

    protected $fillable = [
        'nama',
        'foto_profil',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'email',
        'telepon',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
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
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'alamat' => 'nullable|string',
            'email' => 'required|email|unique:gurus,email'.($id ? ",$id" : ''),
            'telepon' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ];
    }

    // Validation messages
    public static function validationMessages()
    {
        return [
            'nama.required' => 'Nama guru wajib diisi.',
            'nama.string' => 'Nama guru harus berupa teks.',
            'nama.max' => 'Nama guru maksimal 255 karakter.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'telepon.string' => 'Nomor telepon harus berupa teks.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus active atau inactive.',
        ];
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
        return $this->status === 'active' ? 'Aktif' : 'Tidak Aktif';
    }
}
