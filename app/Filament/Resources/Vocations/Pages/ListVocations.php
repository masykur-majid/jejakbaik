<?php

namespace App\Filament\Resources\Vocations\Pages;

use App\Filament\Resources\Vocations\VocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVocations extends ListRecords
{
    protected static string $resource = VocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->slideOver()
            ->modalWidth('md'),
        ];
    }
}
