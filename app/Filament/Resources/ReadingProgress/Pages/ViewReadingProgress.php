<?php

namespace App\Filament\Resources\ReadingProgress\Pages;

use App\Filament\Resources\ReadingProgress\ReadingProgressResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReadingProgress extends ViewRecord
{
    protected static string $resource = ReadingProgressResource::class;

    protected  $listeners = ['refreshReadingProgress' => 'refresh'];

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->slideOver()
                ->label('Edit Progress Information'),
        ];
    }
}
