<?php

namespace App\Filament\Parapoint\Resources\ConductRules\Pages;

use App\Filament\Parapoint\Resources\ConductRules\ConductRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditConductRule extends EditRecord
{
    protected static string $resource = ConductRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
