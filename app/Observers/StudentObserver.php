<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;
use DB;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        DB::transaction(function () use ($student){
            $user  = User::create([
                'name' => $student->student_name,
                'email'=> $student->email,
                'password' => bcrypt('password123'), 
            ]);

            $user->assignRole('siswa');

            $student->user_id = $user->id;
            $student->saveQuietly();
        });
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        //
    }

    public function updating(Student $student): void
    {
        if($student->isDirty(['full_name', 'email'])){
            $student->user->update([
                'name' => $student->student_name,
                'email' => $student->email
            ]);
        }
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        $student->user?->delete();
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }
}
