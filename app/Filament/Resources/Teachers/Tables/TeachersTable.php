<?php

namespace App\Filament\Resources\Teachers\Tables;

use App\Filament\Resources\Teachers\TeacherResource;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nuptk')
                    ->label('NIP / NUPTK')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('teacher_name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable(),
                // TextColumn::make('students_count')
                //     ->label('Monitored Students')
                //     ->counts('students')
                //     ->badge()
                //     ->color(fn (int $state): string => match (true) {
                //         $state === 0 => 'danger',
                //         $state >= 1 => 'primary',
                //     }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->hiddenLabel()
                    ->size('lg')
                    ->tooltip('Edit This Teacher Information')
                    ->modalWidth('lg'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->size('lg')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                CreateAction::make()
                    ->slideOver()
                    ->modalwidth('lg'),
            ]);
    }
}
