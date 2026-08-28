<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                         TextEntry::make('nuptk')
                            ->placeholder('-'),
                        TextEntry::make('teacher_name')
                            ->size('lg')
                            ->weight('black'),
                        TextEntry::make('email')
                            ->label('Email address')
                            ->weight('bold')
                            ->size('lg'),
                    ])
                    ->columns(3)
            ])
            ->columns(1);
    }
}
