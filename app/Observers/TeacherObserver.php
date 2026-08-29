<?php

namespace App\Observers;

use App\Models\Teacher;
use App\Models\User;
use DB;

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     */
    public function created(Teacher $teacher): void
    {
        DB::transaction(function () use ($teacher){
            $user  = User::create([
                'name' => $teacher->teacher_name,
                'email'=> $teacher->email,
                'password' => bcrypt('password123'), 
            ]);

            $user->assignRole('teacher');
            $teacher->user_id = $user->id;
            $teacher->saveQuietly();

        });
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updating(Teacher $teacher): void
    {
        if(is_null($teacher->user_id)){
            $this->created($teacher);
        }
        if($teacher->isDirty(['teacher_name', 'email'])){
            $teacher->user->update([
                'name' => $teacher->teacher_name,
                'email' => $teacher->email
            ]);
        }
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        $teacher->user?->delete();
    }

    /**
     * Handle the Teacher "restored" event.
     */
    public function restored(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     */
    public function forceDeleted(Teacher $teacher): void
    {
        //
    }
}
