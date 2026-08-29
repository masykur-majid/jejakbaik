<?php

namespace App\Filament\Resources\PointLogs\RelationManagers;

use App\Models\ConductRule;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PointLogDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'pointLogDetails';

     public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'student_name')
                    ->dehydrated()
                    ->disabled()
                    ->columnSpan(2)
                    ->required(),
                DatePicker::make('occurrence_date')
                    ->required(),
                Select::make('conduct_rule_id')
                    ->relationship('conductRule', 'conduct_name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (string $state, Set $set, Get $get){
                        if($state){
                            $PointRule = ConductRule::find($state);
                            $occurrence = $get('occurrence_number');
                            $set('conduct_point', $PointRule ? $PointRule->conduct_point : 0);
                            $set('counted_point', $PointRule ? $PointRule->conduct_point*$occurrence : 0);
                        }else{
                            $set('conduct_point', 0);
                        }
                    })
                    ->columnSpanFull(),
                TextInput::make('conduct_point')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(),
                TextInput::make('occurrence_number')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->live()
                    ->afterStateUpdated(function ($state, Get $get, Set $set){
                        $occurrenceNumber = $state;
                        $actionValue = $get('conduct_point');
                        
                        if($actionValue && $occurrenceNumber){
                            $set('counted_point', $occurrenceNumber*$actionValue);
                        }
                        else{
                            $set('counted_point', 0);
                        }
                    }),
                TextInput::make('counted_point')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(),
                Textarea::make('action_notes')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action_notes')
            ->columns([
                TextColumn::make('student.student_name')
                    ->searchable(),
                TextColumn::make('occurrence_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('conductRule.conduct_name')
                    ->searchable(),
                TextColumn::make('conduct_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('occurrence_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('counted_point')
                    ->numeric()
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
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
