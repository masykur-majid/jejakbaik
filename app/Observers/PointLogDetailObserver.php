<?php

namespace App\Observers;

use App\Models\PointLogDetail;
use App\Models\Student;

class PointLogDetailObserver
{
    /**
     * Handle the PointLogDetail "created" event.
     */
    public function created(PointLogDetail $pointLogDetail): void
    {
        $this->updateStudentsPoint(
            studentId: $pointLogDetail->student_id,
            pointAmount: $pointLogDetail->counted_point
        );
    }

    /**
     * Handle the PointLogDetail "updated" event.
     */
    public function updated(PointLogDetail $pointLogDetail): void
    {
        $oldePoint = $pointLogDetail->getOriginal('counted_point');
        $newPoint = $pointLogDetail->counted_point;

        $this->updateStudentsPoint(
            studentId: $pointLogDetail->student_id,
            pointAmount: $newPoint - $oldePoint
        );
    }

    /**
     * Handle the PointLogDetail "deleted" event.
     */
    public function deleted(PointLogDetail $pointLogDetail): void
    {
        $oldePoint = $pointLogDetail->getOriginal('counted_point');
        $newPoint = $pointLogDetail->counted_point;

        $this->updateStudentsPoint(
            studentId: $pointLogDetail->student_id,
            pointAmount: -$pointLogDetail->counted_point
        );
    }

    /**
     * Handle the PointLogDetail "restored" event.
     */
    public function restored(PointLogDetail $pointLogDetail): void
    {
        //
    }

    /**
     * Handle the PointLogDetail "force deleted" event.
     */
    public function forceDeleted(PointLogDetail $pointLogDetail): void
    {
        //
    }

    public function updateStudentsPoint(int $studentId, int $pointAmount)
    {
        Student::where('id', $studentId)
                ->increment('current_points', $pointAmount);
    }

}
