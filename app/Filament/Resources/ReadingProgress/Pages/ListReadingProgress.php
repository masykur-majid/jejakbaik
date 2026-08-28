<?php

namespace App\Filament\Resources\ReadingProgress\Pages;

use App\Filament\Resources\ReadingProgress\ReadingProgressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReadingProgress extends ListRecords
{
    protected static string $resource = ReadingProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth('md'),
        ];
    }
}
