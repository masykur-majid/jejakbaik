<?php

namespace App\Filament\Resources\StudentPoints\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PointLogDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'pointLogDetails';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('point_log_id')
                    ->relationship('pointLog', 'id')
                    ->required(),
                DatePicker::make('occurrence_date')
                    ->required(),
                Select::make('conduct_rule_id')
                    ->relationship('conductRule', 'id')
                    ->required(),
                TextInput::make('conduct_point')
                    ->required()
                    ->numeric(),
                TextInput::make('occurrence_number')
                    ->required()
                    ->numeric(),
                TextInput::make('counted_point')
                    ->required()
                    ->numeric(),
                Textarea::make('action_notes')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('photo')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('pointLog.id')
                    ->label('Point log'),
                TextEntry::make('occurrence_date')
                    ->date(),
                TextEntry::make('conductRule.id')
                    ->label('Conduct rule'),
                TextEntry::make('conduct_point')
                    ->numeric(),
                TextEntry::make('occurrence_number')
                    ->numeric(),
                TextEntry::make('counted_point')
                    ->numeric(),
                TextEntry::make('action_notes')
                    ->columnSpanFull(),
                TextEntry::make('photo'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('conduct_name')
            ->columns([
                TextColumn::make('occurrence_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('conductRule.conduct_name')
                    ->searchable()
                    ->grow(true)
                    ->width('70%')
                    ->wrap()
                    ->alignJustify(),
                TextColumn::make('conduct_point')
                    ->numeric()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('occurrence_number')
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('counted_point')
                    ->numeric()
                    ->width('60px')
                    ->wrap()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('pointLog.teacher.teacher_name')
                    ->numeric()
                    ->width('60px')
                    ->wrap()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
