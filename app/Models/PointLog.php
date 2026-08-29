<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Guarded('id')]
class PointLog extends Model
{
    protected $appends = ['subject_name'];
    
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function pointLogDetails(): HasMany
    {
        return $this->hasMany(PointLogDetail::class, 'point_log_id');
    }

    public function isByStudent(): bool
    {
        return $this->subject_type === Student::class;
    }

    public function isByConduct(): bool
    {
        return $this->subject_type === ConductRule::class;
    }

    public function getSubjectNameAttribute(): string
    {
        return match(class_basename($this->subject_type)){
            'Student' => $this->subject?->student_name ?? '-',
            'ConductRule' => $this->subject?->conduct_name ?? '-',
            default => '-'
        };
    }
}
