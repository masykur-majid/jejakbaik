<?php

namespace App\Filament\Resources\PointLogs\Pages;

use App\Filament\Resources\PointLogs\PointLogResource;
use App\Filament\Resources\PointLogs\RelationManagers\PointLogDetailsRelationManager;
use App\Filament\Resources\PointLogs\Schemas\PointLogForm;
use App\Models\Student;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditByStudent extends EditRecord
{
    protected static string $resource = PointLogResource::class;

    protected static ?string $title = 'Create Log — By Student';

    public function form(Schema $schema): Schema
    {
        // return PointLogForm::configureByStudent($schema);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['subject_type'] = Student::class;
        return $data;
    }

    public function getRelationManagers(): array
    {
        return [
            PointLogDetailsRelationManager::class,
        ];
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         ViewAction::make(),
    //         DeleteAction::make(),
    //     ];
    // }
}
