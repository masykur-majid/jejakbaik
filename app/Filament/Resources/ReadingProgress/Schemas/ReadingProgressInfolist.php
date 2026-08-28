<?php

namespace App\Filament\Resources\ReadingProgress\Schemas;

use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReadingProgressInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Student Identity')
                    ->icon(TablerIcon::InfoSquareRoundedFilled)
                    ->schema([
                        TextEntry::make('student.student_name')
                            ->label('Student Name:')
                            ->size('lg')
                            ->weight('black')
                            ->color('primary')
                            ->numeric(),
                        TextEntry::make('student.classGroup.class_name')
                            ->label('Class:')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric(),
                        TextEntry::make('student.classGroup.vocation.vocation_name')
                            ->label('Class:')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric(),
                    ])
                    ->columns(3),

                Section::make('Book Information')
                    ->icon(TablerIcon::Book2)
                    ->schema([
                        TextEntry::make('book.title')
                            ->label('Book Title:')
                            ->color('primary')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric()
                            ->columnSpan(2),
                        TextEntry::make('book.author')
                            ->label('Book Author:')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric(),
                        TextEntry::make('book.total_pages')
                            ->label('Total Pages:')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric(),
                    ])
                    ->columns(4),
                
                Section::make('Reading Progress')
                    ->icon(TablerIcon::Vocabulary)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'reading' => 'info',
                                'finished' => 'success',
                                'dropped' => 'gray',
                            })
                            ->extraAttributes([
                                'class' => 'my-custom-badge-size',
                            ]),
                        TextEntry::make('current_page')
                            ->size('lg')
                            ->weight('bold')
                            ->numeric(),
                        TextEntry::make('started_at')
                            ->date(),
                        TextEntry::make('finished_at')
                            ->date()
                            ->placeholder('-'),
                    ])->columns(4)
            ])
            ->columns(1);
    }
}
