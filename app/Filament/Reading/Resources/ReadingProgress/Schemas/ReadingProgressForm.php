<?php

namespace App\Filament\Reading\Resources\ReadingProgress\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReadingProgressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->required()
                    ->relationship('student', 'student_name')
                    ->searchable()
                    ->preload(),
                Select::make('book_id')
                    ->required()
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload(),
                Radio::make('status')
                    ->options([
                        'reading' => 'Reading',
                        'finished' => 'Finished',
                        'dropped' => 'Dropped'
                    ])
                    ->inline(true)
                    ->default('reading')
                    ->required(),
                TextInput::make('current_page')
                    ->required()
                    ->disabled()
                    ->default(0)
                    ->numeric()
                    ->dehydrated(),
                DatePicker::make('started_at')
                    ->required(),
                DatePicker::make('finished_at'),
            ])
            ->columns(1);
    }
}
