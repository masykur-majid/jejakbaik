<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Guarded('id')]
class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class, 'class_group_id', 'id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeShowStudentsBelongToTheClass(Builder $query, $classname)
    {
        return $query->where('class_group_id', $classname);
    }
    
    public function scopeShowStudentsDoNotBelongToTheClass(Builder $query, $classname)
    {
        return $query->whereNull('class_group_id')
                     ->orWhere('class_group_id', '!=', $classname);
    }

    //Function for widget adding and removing student to/from a class
    public static function addStudentToTheClass($student_id, $class_id)
    {
        return self::where('id', $student_id)->update(['class_group_id' => $class_id]);
    }

    public static function removeStudentFromTheClass($student_id)
    {
        return self::where('id', $student_id)->update(['class_group_id' => null]);
    }

    public static function countStudentsInThisClass($class_id)
    {
        return self::where('class_group_id', $class_id)->count();
    }

    public static function countStudentsNotInThisClass($class_id)
    {
        return self::where('class_group_id',$class_id)
                    ->orWhereNull('class_group_id')->count();
    }


    //=========================
    // fucntion to add or remove monitor teacher to/from students
    //=========================
    public function scopeShowStudentsMonitoredByThisTeacher(Builder $query, $teacher)
    {
        return $query->where('teacher_id', $teacher);
    }
    public function scopeShowStudentsMonitoredNotByThisTeacher(Builder $query, $teacher)
    {
        return $query->whereNull('teacher_id');
    }
    public static function addMonitoredStudent($student_id, $teacher)
    {
        return self::where('id', $student_id)->update(['teacher_id' => $teacher]);
    }

    public static function removeMonitoredStudent($student_id)
    {
        return self::where('id', $student_id)->update(['teacher_id' => null]);
    }

     public static function countStudentsMonitoredByThisTeacher($teacher)
    {
        return self::where('teacher_id', $teacher)->count();
    }

    public static function countStudentsMonitoredNotByThisTeacher($teacher)
    {
        return self::whereNull('teacher_id')->count();
    }


    //point log
    public function pointLogs(): MorphMany
    {
        return $this->morphMany(PointLog::class, 'subject');
    }

    public function pointLogDetails(): HasMany
    {
        return $this->hasMany(PointLogDetail::class, 'student_id');
    }

    
}
