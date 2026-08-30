<?php

namespace App\Filament\Resources\PointLogs\Pages;

use App\Filament\Resources\PointLogs\PointLogResource;
use App\Models\ClassGroup;
use App\Models\ConductRule;
use App\Models\PointLogDetail;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Override;

class InputForWholeClass extends CreateRecord
{
    protected static string $resource = PointLogResource::class;

    protected static ?string $title = 'Input Poin Massal Per Kelas';

    #[Override]
    protected function getFormActions(): array
    {
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Log Info')
                    ->icon(Heroicon::User)
                    ->schema([

                        Hidden::make('Date')
                            ->dehydrated(false)
                            ->default(now()->format('d M Y')),

                        Select::make('teacher_id')
                            ->label('Guru Pencatat')
                            ->relationship('teacher', 'teacher_name')
                            ->preload()
                            ->columnSpan(1)
                            ->searchable()
                            ->required(),

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
                            ->dehydrated(true),  

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
                                        $occurrence = $get("occurrence_number");
                                        $set('conduct_point', $PointRule ? $PointRule->conduct_point : 0);
                                        $set("counted_point", $PointRule->conduct_point*$occurrence);
                                    }
                                    
                                    else{
                                        $set('conduct_point', 0);
                                    }
                            }),

                        TextInput::make('conduct_point')
                            ->label('Poin')
                            ->disabled()
                            ->dehydrated(),
                        
                         TextInput::make('occurrence_number')
                                ->label('Jumlah Kejadian')
                                ->required()
                                ->numeric()
                                ->live()
                                ->default(1)
                                ->afterStateUpdated(function ($state, Get $get, Set $set){
                                    $occurrenceNumber = $state;
                                    $conductPoint = $get('conduct_point');
                                    
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
                                    $conductPoint = $get('conduct_point');
                                    
                                    return $state ?? $conductPoint;
                                })
                                ->dehydrated(),
                            Textarea::make('action_notes')
                                ->label('Keterangan')
                                ->required()
                                ->columnSpan(3),
                    ])
                    ->columns(3),
                    
                    Actions::make([
                        // Tombol Simpan (Submit)
                        Action::make('save')
                            ->label('Simpan Data')
                            ->submit('form') // Memicu submit form otomatis
                            ->color('primary'),

                        // Tombol Batal (Kembali ke halaman index)
                        Action::make('cancel')
                            ->label('Batal')
                            ->url(static::getResource()::getUrl('index'))
                            ->color('gray'),
                    ])
                ])
                ->columns(1)
                ->extraAttributes([
                    'class' => 'max-w-2xl mx-auto' // Membatasi lebar dan meletakkan di tengah
                ]);;             
    }

    #[Override]
    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function() use ($data){

            $students = Student::where('class_group_id', $data['class_group_id'])->get();

            if($students->isEmpty()){
                Notification::make()
                    ->title('Gagal Menyimpan')
                    ->body('Kelas yang dipilih belum memiliki siswa')
                    ->danger()
                    ->send();
                
                // Melempar exception agar transaksi database dibatalkan dan form tidak tersimpan/redirect
                throw new Exception('Kelas Kosong');
            }

            $pointLog = static::getModel()::create([
                'subject_type' => \App\Models\ConductRule::class,
                'subject_id' => $data['subject_id'],
                'teacher_id' => $data['teacher_id'],

            ]);

            foreach ($students as $student) {
                PointLogDetail::create([
                    'point_log_id' => $pointLog->id,
                    'student_id' => $student->id,
                    'occurrence_date' => $data['occurrence_date'],
                    'conduct_rule_id' => $data['subject_id'],
                    'conduct_point' => $data['conduct_point'],
                    'occurrence_number' => $data['occurrence_number'],
                    'counted_point' => $data['counted_point'],
                    'action_notes'=> $data['action_notes'],
                ]);
            }

            return $pointLog;

        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
