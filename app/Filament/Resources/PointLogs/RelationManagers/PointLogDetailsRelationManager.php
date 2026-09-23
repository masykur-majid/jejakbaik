<?php

namespace App\Filament\Resources\PointLogs\RelationManagers;

use App\Filament\Resources\PointLogs\PointLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PointLogDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'pointLogDetails';

    protected static ?string $relatedResource = PointLogResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
