<?php

namespace App\Filament\Resources\StudentPoints\RelationManagers;

use App\Filament\Resources\StudentPoints\Pages\ViewStudentPoint;
use App\Models\ConductRule;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Override;

class PointLogDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'pointLogDetails';

    #[Override]
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
                    ->label('Nama Siswa')
                    ->dehydrated()
                    ->disabled()
                    ->columnSpan(2)
                    ->required(),
                DatePicker::make('occurrence_date')
                    ->label('Tanggal Kejadian')
                    ->required(),
                Select::make('conduct_rule_id')
                    ->relationship('conductRule', 'conduct_name')
                    ->label('Aturan Poin')
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
                    ->label('poin')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(),
                TextInput::make('occurrence_number')
                    ->label('Jumlah Kejadian')
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
                    ->readOnly()
                    ->dehydrated(),
                Textarea::make('action_notes')
                    ->label('Keterangan')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
            ])
            ->columns(3);
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
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('pointLog.subject_type')
                    ->label('Kategori')
                    ->getStateUsing(function ($record){
                        // dd($record->student_id);
                        if($record->pointLog?->subject_type == 'App\Models\Student'){
                            
                            $conductRule = ConductRule::where('id', $record->pointLog?->subject_id)->first();
                            return $conductRule?->category;
                           
                        }
                        else{
                            // dd("student: ".$record->student_id);
                            $student = Student::where('id', $record->student_id)->first();
                            return $student->student_name;
                        }
                    })
                    ->badge()
                    ->searchable()
                    ->alignJustify(),
                TextColumn::make('conductRule.conduct_name')
                    ->label('Aturan Poin')
                    ->html()
                    ->description(function ($record){
                        if($record->conductRule?->category === 'Achievement'){
                            return new HtmlString("<span class='text-sm' style='color: #15803d; font-style: italic; font-weight: bold; font-size: 0.75rem;' >$record->action_notes</span>");

                        }else{
                            return new HtmlString("<span class='' style='color: #B91C1C; font-style: italic; font-weight: bold; font-size: 0.875rem;' >$record->action_notes</span>");
                        }
                    })
                    ->visible()
                    ->searchable()
                    ->grow(true)
                    ->wrap()
                    ->alignJustify(),
            
                TextColumn::make('conduct_point')
                    ->label('Poin')
                    ->formatStateUsing(function ($record){
                        $point = $record->conduct_point ?? 0;
                        $occur = $record->occurrence_number ?? 0;
                        return "{$point} x {$occur} = ";
                    })
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('counted_point')
                    ->label('Total')
                    ->badge()
                    ->numeric()
                    ->width('60px')
                    ->wrap()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('pointLog.teacher.teacher_name')
                    ->label('Guru Pencatat')
                    ->badge()
                    ->color(Color::Taupe)
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
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    // ViewAction::make(),
                        EditAction::make()
                            ->label('Edit Data')
                            ->after(function(){
                                $this->dispatch('refreshStudentPoint');
                            }),
                        Action::make('view-image')
                            ->modal()
                            ->label('Lihat Bukti')
                            ->icon(Heroicon::Photo)
                            ->modalHeading('Foto Bukti')
                            ->modalContent(fn ($record) => new HtmlString(
                                '<div class="flex justify-center h-6">
                                    <img src="'.Storage::disk('r2')->url($record->evidence_photo).'"
                                        class="max-h-16 w-auto object-contain rounded-lg" alt="Bukti Foto">
                                </div>'
                            ))
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->slideOver()
                            ->modalWidth('md'),
                        // DissociateAction::make(),
                        DeleteAction::make()
                            ->label('Hapus'),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
