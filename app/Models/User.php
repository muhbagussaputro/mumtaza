<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telepon',
        'foto_path',
        'nis',
        'nisn',
        'orang_tua_nama',
        'orang_tua_telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'class_id',
        'status_aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    // Relasi untuk siswa
    public function classHistories(): HasMany
    {
        return $this->hasMany(ClassStudentHistory::class, 'student_id');
    }

    public function classRoom()
    {
        return $this->hasOneThrough(
            ClassRoom::class,
            ClassStudentHistory::class,
            'student_id', // Foreign key on ClassStudentHistory table
            'id', // Foreign key on ClassRoom table
            'id', // Local key on User table
            'class_id' // Local key on ClassStudentHistory table
        )->where('class_student_histories.active', true);
    }

    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class, 'student_id');
    }

    public function memorizations(): HasMany
    {
        return $this->hasMany(MemorizationEntry::class, 'student_id');
    }

    // Relasi untuk guru
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'guru_id');
    }

    public function guidedMemorizations(): HasMany
    {
        return $this->hasMany(MemorizationEntry::class, 'guru_id');
    }

    // Scope untuk role
    public function scopeStudents($query)
    {
        return $query->where('role', 'siswa');
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'guru');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }
}
