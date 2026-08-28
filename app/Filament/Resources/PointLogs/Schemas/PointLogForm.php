<?php

namespace App\Filament\Resources\PointLogs\Schemas;

use App\Models\ClassGroup;
use App\Models\ConductRule;
use App\Models\PointRule;
use App\Models\Student;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PointLogForm
{
    public static function configureByStudent(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Log Info')
                    ->icon(Heroicon::User)
                    ->schema([
                        Hidden::make('subject_type')
                            ->default('student')
                            ->dehydrated(),
                        Select::make('subject_id')
                            ->label('Student')
                            ->options(Student::pluck('student_name', 'id'))
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('teacher_id')
                            ->label('Teacher Who Recorded')
                            ->relationship('teacher', 'teacher_name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])
                    ->columns(2),
                    
                    Repeater::make('pointLogDetails')
                        ->hiddenLabel()
                        ->relationship('pointLogDetails')
                        ->addActionLabel('Tambah Catatan Poin')
                        ->schema([
                            Select::make('conduct_rule_id')
                                ->relationship('conductRule', 'conduct_name')
                                ->preload()
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (string $state, Set $set){
                                    if($state){
                                        $PointRule = ConductRule::find($state);
                                        $set('conduct_point', $PointRule ? $PointRule->conduct_point : 0);
                                        $set('counted_point', $PointRule ? $PointRule->conduct_point : 0);
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
                            DatePicker::make('occurrence_date')
                                ->required(),
                            FileUpload::make('photo')
                                ->required()
                                ->columnSpan(2),
                            ])
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record){
                            $data['student_id'] = $record->subject_id;
                            return $data;
                        })
                        ->columns(3)
                        ->grid(2)
                ])
                ->columns(1);             
    }

    public static function configureByConduct(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Log Info')
                    ->icon(Heroicon::User)
                    ->schema([
                        Hidden::make('subject_type')
                            ->default('conduct')
                            ->dehydrated(),
                        TextInput::make('Date')
                            ->dehydrated(false)
                            ->readOnly()
                            ->default(now()->format('d M Y')),
                        Select::make('teacher_id')
                            ->label('Teacher Who Recorded')
                            ->relationship('teacher', 'teacher_name')
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('subject_id')
                            ->label('Conduct')
                            ->options(ConductRule::pluck('conduct_name', 'id'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function (string $state, Set $set, Get $get){
                                    $repeaterItems = $get('pointLogDetails') ?? [];
                                    if($state){
                                        $PointRule = ConductRule::find($state);
                                        $set('conduct_point', $PointRule ? $PointRule->conduct_point : 0);
                                        $set('counted_point', $PointRule->conduct_point);

                                        foreach ($repeaterItems as $uuid => $item) {
                                            // Tembak field 'occurrence_number' di dalam repeater berdasarkan UUID-nya
                                            $set("pointLogDetails.{$uuid}.counted_point", $PointRule->conduct_point);
                                        }
                                    }
                                    
                                    else{
                                        $set('conduct_point', 0);
                                    }
                                }),
                        TextInput::make('conduct_point')
                            ->readOnly()
                            ->dehydrated(),
                    ])
                    ->columns(2),
                    
                    Repeater::make('pointLogDetails')
                        ->relationship('pointLogDetails')
                        
                        ->schema([
                            Select::make('class_group_id')
                                ->placeholder('select class')  
                                ->options(function(){
                                    return ClassGroup::query()->pluck('class_name', 'id');
                                })    
                                ->live()
                                ->dehydrated(false)
                                ->columnSpan(1),
                            Select::make('student_id')
                                ->placeholder('select students')
                                ->options(function(Get $get){
                                    $selectedClass = $get('class_group_id');
                                    if(!$selectedClass){
                                        return [];
                                    }
                                    return Student::query()
                                        ->where('class_group_id', $selectedClass)
                                        ->pluck('student_name', 'id');
                                })
                                ->preload()
                                ->searchable()
                                ->columnSpan(2),
                            DatePicker::make('occurrence_date')
                                ->required(),
                            TextInput::make('occurrence_number')
                                ->required()
                                ->numeric()
                                ->live()
                                ->default(1)
                                ->afterStateUpdated(function ($state, Get $get, Set $set){
                                    $occurrenceNumber = $state;
                                    $conductPoint = $get('../../conduct_point');
                                    
                                    if($conductPoint && $occurrenceNumber){
                                        $set('counted_point', $occurrenceNumber*$conductPoint);
                                    }
                                    else{
                                        $set('counted_point', $conductPoint);
                                    }
                                }),
                            TextInput::make('counted_point')
                                ->required()
                                ->numeric()
                                ->readOnly()
                                ->live()
                                ->formatStateUsing(function ($state, Get $get, Set $set){
                                    $occurrenceNumber = $get('occurrence_number');
                                    $conductPoint = $get('../../conduct_point');
                                    
                                    return $state ?? $conductPoint;
                                })
                                ->dehydrated(),
                            Textarea::make('action_notes')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),
                            FileUpload::make('photo')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->grid(2)
                        ->cloneable()
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record, $component){
                            $data['conduct_rule_id'] = $record->subject_id;

                            $conductPoint = $component->getLivewire()->data['conduct_point'] ?? 0;
                            $data['conduct_point'] = $conductPoint;
                            return $data;
                        })
                ])
                ->columns(1);             
    }
}
