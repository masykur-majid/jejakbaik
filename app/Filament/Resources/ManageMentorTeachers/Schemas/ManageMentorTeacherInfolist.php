<?php

namespace App\Filament\Resources\ManageMentorTeachers\Schemas;

use App\Livewire\StudentsMonitoredByThisTeacher;
use App\Livewire\StudentsMonitoredNotByThisTeacher;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageMentorTeacherInfolist
{
    
    public $record;
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
                    ->columns(3),
            ])
            ->columns(1);
    }
}
