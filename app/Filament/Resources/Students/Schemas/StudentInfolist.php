<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('nisn')
                    ->placeholder('-'),
                TextEntry::make('nis')
                    ->placeholder('-'),
                TextEntry::make('student_name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('current_grade'),
                TextEntry::make('classgroup_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('teacher_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
