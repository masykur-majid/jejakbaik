<?php

namespace  App\Filament\Resources\ClassGroups\Tables;

use App\Filament\Resources\ClassGroups\ClassGroupResource;
use Auth;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class ClassGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('class_name')
                    ->searchable(),
                TextColumn::make('vocation.vocation_name')
                    ->searchable(),
                TextColumn::make('teacher.teacher_name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('students_count')
                    ->badge()
                    ->label('Members')
                    ->counts('students')
                    ->size(TextSize::Large)
                    ->weight('black')
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state >= 1 => 'info',
                    })
                    ->sortable(),
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
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->tooltip('View Class Members')
                    ->iconSize('lg')
                    ->icon(TablerIcon::ClipboardSearch)
                    ->color('mauve'),
                EditAction::make()
                    ->slideOver()
                    ->modalWidth('md')
                    ->color('primary')
                    ->hiddenLabel()
                    ->tooltip('Edit This Class')
                    ->icon(Heroicon::PencilSquare)
                    ->iconSize('lg'),
                
                Action::make('Manage_members')
                    ->hiddenLabel()
                    ->tooltip('Manage Members')
                    ->icon(TablerIcon::ReplaceUser)
                    ->iconSize('lg')
                    ->color('info')
                   ->url(fn ($record): string => ClassGroupResource::getUrl('manage',['record'=>$record]))
                   ->hidden(fn () => Auth::user()->hasRole('guru')),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete This Class')
                    ->iconSize('lg')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
