<?php

namespace App\Filament\Resources\Vocations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('vocation_code')
                    ->required(),
                TextInput::make('vocation_name')
                    ->required(),
            ])
            ->columns(1);
    }
}
