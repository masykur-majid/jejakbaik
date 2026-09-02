<?php

namespace App\Filament\Resources\StudentPoints\Tables;

use App\Filament\Imports\StudentImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentPointsTable
{
    
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn'),
                TextColumn::make('student_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('classGroup.class_name'),
                TextColumn::make('current_points')
                    ->label('Point')
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state <= 0 => 'Colour4',
                        $state <= 50 => 'danger',
                        $state <= 100 => 'warning',
                        default       => 'success',
                    })
                    
            ])
            ->filters([
                 SelectFilter::make('class_group_id')
                    ->label('Class Name')
                    ->relationship('classgroup', 'class_name')
                    ->placeholder('-'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
