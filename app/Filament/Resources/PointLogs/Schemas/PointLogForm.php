<?php

namespace App\Filament\Resources\PointLogs\Schemas;

use App\Models\ClassGroup;
use App\Models\ConductRule;
use App\Models\PointRule;
use App\Models\Student;
use App\Models\Teacher;
use App\Support\ImageUploadHelper;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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
                            ->label('Nama Siswa')
                            ->options( function (){
                                if(auth()->user()->hasRole('super_admin')){
                                    return Student::pluck('student_name', 'id');
                                }

                                $teacher = Teacher::where('user_id', auth()->id())->with('classgroups')->first();

                                if($teacher && $teacher->classgroups){
                                    $classGroupIds = $teacher->classgroups->pluck('id')->toArray();
                                    return Student::whereIn('class_group_id', $classGroupIds)
                                                        ->pluck('student_name', 'id');
                                }
                                return [];                                
                            })
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('teacher_id')
                            ->label('Nama Guru Pencatat')
                            ->relationship('teacher', 'teacher_name', function (Builder $query){
                                if(!auth()->user()->hasRole('super_admin')){
                                    return $query->where('user_id', auth()->id());
                                }
                                return $query;
                            })
                            ->default(!auth()->user()->hasRole('admin') ? Teacher::where('user_id', auth()->id())->value('id') : null)
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
                                ->label('Aturan Poin Yang Dikerjakan')
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
                            DatePicker::make('occurrence_date')
                                ->label('Tanggal Kejadian')
                                ->required(),
                            TextInput::make('conduct_point')
                                ->label('Poin')
                                ->required()
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('occurrence_number')
                                ->label('Banyak Kejadian')
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
                                ->label('Total Poin')
                                ->required()
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),
                            Textarea::make('action_notes')
                                ->label('Keterangan')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),
                            FileUpload::make('evidence_photo')
                                ->label('Foto Bukti')
                                ->disk('r2')
                                ->directory('uploads/images')
                                ->image()
                                ->saveUploadedFileUsing(function ($file, Get $get) {
                                    $studentId = $get('../../subject_id');
                                    $student = Student::with('classGroup')->find($studentId);
                                    $classGroupSlug =   $student && $student->classGroup
                                                        ? Str::slug($student->classGroup->class_name)
                                                        : 'unknown-class';
                                    $directory = "uploads/images/".strtoupper($classGroupSlug);
                                    // dd($directory);
                                    return ImageUploadHelper::convertAndStore(
                                        file: $file,
                                        directory: $directory,
                                        disk: 'r2',
                                        quality: 80,
                                        maxWidth: 1200
                                    );
                                })
                                ->required(),
                            ])
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record){
                            $data['student_id'] = $record->subject_id;
                            return $data;
                        })
                        ->columns(2)
                        ->grid(3),
                    
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
                        Hidden::make('Date')
                            ->dehydrated(false)
                            ->default(now()->format('d M Y')),
                        Select::make('teacher_id')
                            ->label('Guru Pencatat')
                            ->columnSpan(2)
                            ->relationship('teacher', 'teacher_name')
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('subject_id')
                            ->label('Aturan Poin yang Dikerjakan')
                            ->options(ConductRule::pluck('conduct_name', 'id'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan(3)
                            ->live()
                            ->afterStateUpdated(function (string $state, Set $set, Get $get){
                                    $repeaterItems = $get('pointLogDetails') ?? [];
                                    if($state){
                                        $PointRule = ConductRule::find($state);
                                        $set('conduct_point', $PointRule ? $PointRule->conduct_point : 0);
                                       
                                        foreach ($repeaterItems as $uuid => $item) {
                                            // Tembak field 'occurrence_number' di dalam repeater berdasarkan UUID-nya
                                            $occurrence = $get("pointLogDetails.{$uuid}.occurrence_number");
                                            $set("pointLogDetails.{$uuid}.counted_point", $PointRule->conduct_point*$occurrence);
                                        }
                                    }
                                    
                                    else{
                                        $set('conduct_point', 0);
                                    }
                                }),
                        TextInput::make('conduct_point')
                            ->label('Poin')
                            ->disabled()
                            ->dehydrated(),
                        
                        
                    ])
                    ->columns(6),
                    
                    Repeater::make('pointLogDetails')
                        ->relationship('pointLogDetails')
                        
                        ->schema([
                            DatePicker::make('occurrence_date')
                                ->label('Tanggal Kejadian')
                                ->required(),
                            Select::make('class_group_id')
                                ->label('Kelas')
                                ->placeholder('Pilih Kelas')  
                                ->options(function(){
                                    if(!auth()->user()->hasRole('super_admin')){
                                        $teacherId = Teacher::where('user_id', auth()->id())->value('id');    
                                        return ClassGroup::query()->where('form_teacher', $teacherId)->pluck('class_name', 'id');
                                    }
                                    return ClassGroup::query()->pluck('class_name', 'id');
                                })    
                                ->live()
                                ->dehydrated(false)
                                ->columnSpan(1),
                            Select::make('student_id')
                                ->label('Nama Siswa')
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
                            TextInput::make('occurrence_number')
                                ->label('Jumlah Kejadian')
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
                                ->label('Total Poin')
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
                                ->label('Keterangan')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),
                            FileUpload::make('evidence_photo')
                                ->label('Foto Bukti')
                                ->disk('r2')
                                ->directory('uploads/images')
                                ->image()
                                ->saveUploadedFileUsing(function ($file, Get $get) {
                                    $classId = $get('class_group_id');
                                    $ClassName = ClassGroup::where('id', $classId)->value('class_name');
                                    $classGroupSlug =   $ClassName ?? 'unknown-class';
                                    $directory = "uploads/images/".strtoupper($classGroupSlug);
                                    // dd($directory);
                                    return ImageUploadHelper::convertAndStore(
                                        file: $file,
                                        directory: $directory,
                                        disk: 'r2',
                                        quality: 80,
                                        maxWidth: 1200
                                    );
                                })
                                ->required(),
                        ])
                        ->columns(2)
                        ->grid(3)
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
