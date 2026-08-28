<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable( 'reading_progress_id', 
            'date_read', 
            'start_page', 
            'end_page', 
            'total_page_read', 
            'summary',
            'verified', 
            'teacher_id',
            'teacher_note'
        )]
class ReadingLog extends Model
{
    /** @use HasFactory<\Database\Factories\ReadingLogFactory> */
    use HasFactory;

    public function readingProgress(): BelongsTo
    {
        return $this->belongsTo(ReadingProgress::class, 'reading_progress_id', 'id');
    }
}
