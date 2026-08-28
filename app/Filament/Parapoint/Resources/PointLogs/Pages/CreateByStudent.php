<?php

namespace App\Filament\Parapoint\Resources\PointLogs\Pages;

use App\Filament\Parapoint\Resources\PointLogs\PointLogResource;
use App\Filament\Parapoint\Resources\PointLogs\Schemas\PointLogForm;
use App\Models\Student;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateByStudent extends CreateRecord
{
    protected static string $resource = PointLogResource::class;
    protected  ?bool $hasDatabaseTransactions = true;

    protected static ?string $title = 'Create Log — By Student';

    public function form(Schema $schema): Schema
    {
        return PointLogForm::configureByStudent($schema);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['subject_type'] = Student::class;
        return $data;
    }
}
