<?php

namespace App\Filament\Resources\Students\Tables;

use App\Filament\Imports\StudentImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('student_name')
                    ->label('Students Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('current_grade')
                    ->label('Grade')
                    ->searchable(),
                TextColumn::make('classgroup.class_name')
                    ->label('Class')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('teacher.teacher_name')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->color('mauve'),
                EditAction::make()
                    ->hiddenLabel(),
                DeleteAction::make()
                    ->hiddenLabel()
            ], position:RecordActionsPosition::BeforeCells)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(StudentImporter::class)
            ]);
    }
}
