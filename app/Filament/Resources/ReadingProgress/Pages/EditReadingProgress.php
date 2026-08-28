<?php

namespace App\Filament\Resources\ReadingProgress\Pages;

use App\Filament\Resources\ReadingProgress\ReadingProgressResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReadingProgress extends EditRecord
{
    protected static string $resource = ReadingProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
