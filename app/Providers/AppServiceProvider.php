<?php

namespace App\Providers;

use App\Models\ConductRule;
use App\Models\PointLog;
use App\Models\PointLogDetail;
use App\Models\ReadingLog;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Observers\PointLogDetailObserver;
use App\Observers\PointLogObserver;
use App\Observers\ReadingLogObserver;
use App\Observers\StudentObserver;
use App\Observers\TeacherObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Teacher::observe(TeacherObserver::class);
        Student::observe(StudentObserver::class);
        ReadingLog::observe(ReadingLogObserver::class);
        PointLogDetail::observe(PointLogDetailObserver::class);
        PointLog::observe(PointLogObserver::class);

         Relation::morphMap([
            'conduct' => ConductRule::class,
            'student' => Student::class,
        ]);

    }
}
