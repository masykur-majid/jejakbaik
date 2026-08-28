<?php

namespace App\Filament\Resources\ConductRules\Pages;

use App\Filament\Resources\ConductRules\ConductRuleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewConductRule extends ViewRecord
{
    protected static string $resource = ConductRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
