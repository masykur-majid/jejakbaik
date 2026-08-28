<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable('class_name', 'vocational', 'form_teacher')]
class ClassGroup extends Model
{
    /** @use HasFactory<\Database\Factories\ClassgroupFactory> */
    use HasFactory;

    public function teacher(): BelongsTo{
        return $this->belongsTo(Teacher::class, 'form_teacher', 'id');
    }

    public function vocation(): BelongsTo{
        return $this->belongsTo(Vocation::class, 'code_of_vocation', 'vocation_code');
    }

    public function students(): HasMany{
        return $this->hasMany(Student::class, 'class_group_id', 'id');
    }
}

