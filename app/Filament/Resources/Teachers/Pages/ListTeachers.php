<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use App\Models\Teacher;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    public function mount(): void
    {   
        parent::mount();
        $user = auth()->user();
        if($user->hasRole('guru')){
            $teacherRecord = Teacher::where('user_id', $user->id)->first();

            if($teacherRecord){
                redirect(static::getResource::getUrl('view', ['record' => $teacherRecord]));
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make()
            //     ->slideOver()
            //     ->modalwidth('lg'),
        ];
    }
}
