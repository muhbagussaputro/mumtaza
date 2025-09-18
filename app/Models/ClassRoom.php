<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'nama',
        'tahun_ajaran',
    ];

    public function studentHistories(): HasMany
    {
        return $this->hasMany(ClassStudentHistory::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_student_histories', 'class_id', 'student_id')
            ->wherePivot('active', true)
            ->withPivot(['tahun_ajaran', 'active'])
            ->withTimestamps();
    }
}
