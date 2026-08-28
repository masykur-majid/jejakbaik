<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable('user_id', 'nuptk', 'teacher_name', 'email')]
class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function students(): HasMany{
        return $this->hasMany(Student::class, 'teacher_id', 'id');
    }
    public function classgroups(): hasMany{
        return $this->hasMany(Classgroup::class, 'form_teacher', 'id');
    }


}
