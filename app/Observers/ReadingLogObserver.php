<?php

namespace App\Observers;

use App\Models\ReadingLog;
use App\Models\ReadingProgress;

class ReadingLogObserver
{
    /**
     * Handle the ReadingLog "created" event.
     */
    public function created(ReadingLog $readingLog): void
    {
        $this->syncProgress($readingLog->reading_progress_id);
    }

    /**
     * Handle the ReadingLog "updated" event.
     */
    public function updated(ReadingLog $readingLog): void
    {
        
         if($readingLog->wasChanged('end_page')){
            $this->syncProgress($readingLog->reading_progress_id);
        }
    }

    /**
     * Handle the ReadingLog "deleted" event.
     */
    public function deleted(ReadingLog $readingLog): void
    {
       $this->syncProgress($readingLog->reading_progress_id);
    }

    /**
     * Handle the ReadingLog "restored" event.
     */
    public function restored(ReadingLog $readingLog): void
    {
        //
    }

    /**
     * Handle the ReadingLog "force deleted" event.
     */
    public function forceDeleted(ReadingLog $readingLog): void
    {
        //
    }

    public function syncProgress(int $progressId): void
    {
        $progress = ReadingProgress::find($progressId);

        if($progress){
            $lastLog = ReadingLog::where('reading_progress_id', $progress->id)
                                        ->orderBy('end_page', 'desc')
                                        ->first();
        }

        $newCurrentPage = $lastLog ? $lastLog->end_page : 0;
        $readDate = $lastLog->date_read;
        $progress->updateProgress($newCurrentPage, $readDate);
    }
}
