<?php

namespace App\Filament\Resources\ClassGroups\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClassGroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('class_name'),
                        TextEntry::make('vocation.vocation_name')
                            ->placeholder('-'),
                        TextEntry::make('teacher.teacher_name')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('students_count')
                            ->counts('students')
                            ->suffix(' students')
                            ->label('Members')
                            ->placeholder('-'),
                        // TextEntry::make('created_at')
                        //     ->dateTime()
                        //     ->placeholder('-'),
                        // TextEntry::make('updated_at')
                        //     ->dateTime()
                        //     ->placeholder('-'),
                    ])
                    ->columns(4)
            ])
            ->columns(1);
    }
}
