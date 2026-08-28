<?php

namespace App\Filament\Resources\ManageMentorTeachers\Pages;

use App\Filament\Resources\ManageMentorTeachers\ManageMentorTeacherResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManageMentorTeachers extends ListRecords
{
    protected static string $resource = ManageMentorTeacherResource::class;
    protected static ?string $title = 'Data Guru Wali';
    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
