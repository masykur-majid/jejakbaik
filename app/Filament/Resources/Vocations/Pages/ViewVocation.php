<?php

namespace App\Filament\Resources\Vocations\Pages;

use App\Filament\Resources\Vocations\VocationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVocation extends ViewRecord
{
    protected static string $resource = VocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
            ->slideOver()
            ->modalWidth('md'),
        ];
    }
}
