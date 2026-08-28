<?php

namespace App\Filament\Resources\ManageMentorTeachers\Pages;

use App\Filament\Resources\ManageMentorTeachers\ManageMentorTeacherResource;
use App\Livewire\StudentsMonitoredByThisTeacher;
use App\Livewire\StudentsMonitoredNotByThisTeacher;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewManageMentorTeacher extends ViewRecord
{
    protected static string $resource = ManageMentorTeacherResource::class;
    protected static ?string $title = 'Kelola Siswa Binaan';
    
    protected function getFooterWidgets(): array
    {
        return [
            StudentsMonitoredByThisTeacher::class,
            StudentsMonitoredNotByThisTeacher::class,
        ];
    }

    // WAJIB: Mengirim data record ke widget agar query where('student_id', ...) bekerja
    public function getWidgetData(): array
    {
        return [
            'record' => $this->getRecord(),
        ];
    }
}
