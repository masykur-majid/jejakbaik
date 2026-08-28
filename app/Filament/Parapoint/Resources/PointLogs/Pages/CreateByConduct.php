<?php

namespace App\Filament\Parapoint\Resources\PointLogs\Pages;

use App\Filament\Parapoint\Resources\PointLogs\PointLogResource;
use App\Filament\Parapoint\Resources\PointLogs\Schemas\PointLogForm;
use App\Models\ConductRule;
use App\Models\Student;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateByConduct extends CreateRecord
{
    protected static string $resource = PointLogResource::class;
    protected ?bool $hasDatabaseTransactions = true;

    protected static ?string $title = 'Create Log — By Student';

    public function form(Schema $schema): Schema
    {
        return PointLogForm::configureByConduct($schema);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['subject_type'] = ConductRule::class;
        return $data;
    }
}
