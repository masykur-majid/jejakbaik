<?php

namespace App\Filament\Resources\Vocations;

use App\Filament\Resources\Vocations\Pages\ListVocations;
use App\Filament\Resources\Vocations\Schemas\VocationForm;
use App\Filament\Resources\Vocations\Schemas\VocationInfolist;
use App\Filament\Resources\Vocations\Tables\VocationsTable;
use App\Models\Vocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VocationResource extends Resource
{
    protected static ?string $model = Vocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?string $navigationLabel = 'Vocation';
    protected static string| UnitEnum |null $navigationGroup = 'Akademik';

    public static function form(Schema $schema): Schema
    {
        return VocationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVocations::route('/'),
            // 'create' => CreateVocation::route('/create'),
            // 'view' => ViewVocation::route('/{record}'),
            // 'edit' => EditVocation::route('/{record}/edit'),
        ];
    }
}
