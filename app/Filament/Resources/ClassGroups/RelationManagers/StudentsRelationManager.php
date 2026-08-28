<?php

namespace  App\Filament\Resources\ClassGroups\RelationManagers;

use App\Filament\Resources\ClassGroups\ClassGroupResource;
use App\Filament\Resources\ClassGroups\Pages\ViewClassGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $title = 'Student in This Class';

    public static function canViewForRecord($ownerRecord, string $pageClass): bool
    {
        return $pageClass === ViewClassGroup::class;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_name')
            ->columns([
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                TextColumn::make('student_name')
                    ->label('Students Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable(),
                TextColumn::make('current_grade')
                    ->label('Grade')
                    ->searchable(),
            ]);
    }
}
