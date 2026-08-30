<?php

namespace App\Observers;

use App\Models\PointLog;
use App\Models\Student;

class PointLogObserver
{
    /**
     * Handle the PointLog "created" event.
     */
    public function created(PointLog $pointLog): void
    {
        //
    }

    /**
     * Handle the PointLog "updated" event.
     */
    public function updated(PointLog $pointLog): void
    {
        //
    }

    /**
     * Handle the PointLog "deleted" event.
     */
    public function deleted(PointLog $pointLog): void
    {
        //
    }

     public function deleting(PointLog $pointLog): void
    {
        $details = $pointLog->pointLogDetails; 
        foreach ($details as $detail){
            Student::where('id', $detail->student_id)->decrement('current_points', $detail->counted_point);
        }
    }

    /**
     * Handle the PointLog "restored" event.
     */
    public function restored(PointLog $pointLog): void
    {
        //
    }

    /**
     * Handle the PointLog "force deleted" event.
     */
    public function forceDeleted(PointLog $pointLog): void
    {
        //
    }
}
