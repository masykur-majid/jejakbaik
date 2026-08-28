<?php

namespace App\Filament\Imports;

use App\Models\ConductRule;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ConductRuleImporter extends Importer
{
    protected static ?string $model = ConductRule::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('category')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('conduct_name')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('conduct_point')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),
            ImportColumn::make('follow_up_action')
                // ->requiredMapping()
                // ->rules(['required']),
        ];
    }

    public function resolveRecord(): ConductRule
    {
        return new ConductRule();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your conduct rule import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
