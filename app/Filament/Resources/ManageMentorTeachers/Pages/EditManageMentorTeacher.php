<?php

namespace App\Filament\Resources\ManageMentorTeachers\Pages;

use App\Filament\Resources\ManageMentorTeachers\ManageMentorTeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditManageMentorTeacher extends EditRecord
{
    protected static string $resource = ManageMentorTeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //ViewAction::make(),
            //DeleteAction::make(),
        ];
    }
}
