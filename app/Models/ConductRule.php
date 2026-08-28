<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Guarded('id')]
class ConductRule extends Model
{
    public function pointLogDetails(): HasMany
    {
        return $this->hasMany(PointLogDetail::class, 'point_log_id');
    }

    public function pointLogs(): MorphMany
    {
        return $this->morphMany(PointLog::class, 'subject');
    }
}
