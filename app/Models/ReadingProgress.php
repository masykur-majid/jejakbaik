<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable('student_id', 'book_id', 'status', 'current_page', 'started_at', 'finished_at')]
class ReadingProgress extends Model
{
    /** @use HasFactory<\Database\Factories\ReadingProgressFactory> */
    use HasFactory;
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function readingLogs(): HasMany
    {
        return $this->hasMany(ReadingLog::class, 'reading_progress_id', 'id');
    }
    public function updateProgress(int $lastPageRead, string $readDate): void
    {
        $this->current_page = $lastPageRead;
        
        if($this->current_page >= $this->book->total_pages){
            $this->status = 'finished';
            $this->finished_at = $readDate;
        }else{
            $this->status = 'reading';
            $this->finished_at = null;
        }
        
        $this->save();
    }
}
