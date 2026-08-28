<?php

namespace App\Filament\Reading\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('author')
                    ->required(),
                TextInput::make('total_pages')
                    ->required()
                    ->numeric()
                    ->maxLength(4),
            ])
            ->columns(1);
    }
}
