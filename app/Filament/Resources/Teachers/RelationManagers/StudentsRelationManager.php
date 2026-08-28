<?php

namespace App\Filament\Resources\Teachers\RelationManagers;

use App\Filament\Resources\Teachers\Pages\ViewTeacher;
use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public static function canViewForRecord($ownerRecord, string $pageClass): bool
    {
        return $pageClass === ViewTeacher::class;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_name')
            ->heading('SISWA BINAAN')
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
                TextColumn::make('classgroup.class_name')
                    ->label('Class')
                    ->placeholder('-')
                    ->sortable()
            ])
            ->headerActions([
            ]);
    }
}
