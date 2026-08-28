<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded('id')]
class PointLogDetail extends Model
{
    public function pointLog(): BelongsTo
    {
        return $this->belongsTo(PointLog::class, 'point_log_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function conductRule(): BelongsTo
    {
        return $this->belongsTo(ConductRule::class, 'conduct_rule_id');
    }
}
