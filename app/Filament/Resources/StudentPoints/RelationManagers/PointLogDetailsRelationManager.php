<?php

namespace App\Filament\Resources\StudentPoints\RelationManagers;

use App\Models\ConductRule;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
                Split::make([
                    TextColumn::make('counted_point')
                        ->grow(false)
                        ->extraAttributes(['class' => 'point-large'])
                        ->weight(FontWeight::Light)
                        ->color(function ($record){
                            return $record->conductRule?->category == 'Achievement' ? Color::Green : Color::Red;
                        })
                        ->getStateUsing(function ($record){
                            return $record->counted_point > 0 ? '+'.$record->counted_point : '-'.$record->counted_point;
                        }),

                    // IconColumn::make('pointLog.subject_type')
                    //     ->icon(function ($record) {
                    //         // dd($record->conductRule?->category);
                    //         if($record->pointLog?->subject_type != 'App\Models\Student'){
                    //             return Heroicon::UserCircle;
                    //         }
                    //         else{
                    //             return $record->conductRule?->category == 'Achievement' ? Heroicon::PlusCircle : Heroicon::MinusCircle;
                    //         }
                    //     })
                    //     ->color(function ($record) {
                    //         if($record->pointLog?->subject_type != 'App\Models\Student'){
                    //             return Color::Violet;
                    //         }
                    //         else{
                    //             return $record->conductRule?->category == 'Achievement' ? Color::Green : Color::Red;
                    //         }
                    //     })
                    //     ->grow(false)
                    //     ->size('xl')
                    //     ->extraAttributes(['class' => '!items-start [&_svg]:mt-1']),

                    Stack::make([
                        TextColumn::make('pointLog.subject_type')
                            ->label('Kategori')
                            ->getStateUsing(function ($record){
                                if($record->pointLog?->subject_type == 'App\Models\Student'){
                                    return $record->conductRule?->category == 'Achievement' ? 'Prestasi' : 'Pelanggaran';
                                }
                                else{
                                    return $record->student?->student_name;
                                }
                            })
                            ->weight(FontWeight::Bold)
                            ->color(function ($record){
                                if($record->pointLog?->subject_type == 'App\Models\Student'){
                                    return $record->conductRule?->category == 'Achievement' ? Color::Green : Color::Red;
                                }
                                else{
                                    return Color::Violet;
                                }
                            })
                            ->icon(function ($record) {
                                // dd($record->conductRule?->category);
                                if($record->pointLog?->subject_type != 'App\Models\Student'){
                                    return Heroicon::UserCircle;
                                }
                                else{
                                    return $record->conductRule?->category == 'Achievement' ? Heroicon::PlusCircle : Heroicon::MinusCircle;
                                }
                            })
                            ->iconColor(function ($record){
                                if($record->pointLog?->subject_type == 'App\Models\Student'){
                                    return $record->conductRule?->category == 'Achievement' ? Color::Green : Color::Red;
                                }
                                else{
                                    return Color::Violet;
                                }
                            })
                            ->size('2xl')
                            ->searchable()
                            ->alignJustify(),
                                               
                        TextColumn::make('conductRule.conduct_name')
                            ->label('Aturan Poin')
                            ->html()
                            ->visible()
                            ->searchable()
                            ->grow(true)
                            ->wrap()
                            ->size('xs')
                            ->color(Color::Mauve),

                        TextColumn::make('occurrence_date')
                            ->label('Tanggal')
                            ->date()
                            ->grow(false)
                            ->size('xs')
                            ->color(Color::Slate)
                            ->sortable(),
                    ])->space(0),
                    
                
                    TextColumn::make('conduct_point')
                        ->label('Poin')
                        ->grow(false)
                        ->formatStateUsing(function ($record){
                            $point = $record->conduct_point ?? 0;
                            $occur = $record->occurrence_number ?? 0;
                            return "{$point} x {$occur} = ";
                        })
                        ->extraHeaderAttributes(['class' => 'whitespace-normal']),

                    TextColumn::make('counted_point')
                        ->label('Total')
                        ->grow(false)
                        ->badge()
                        ->numeric()
                        ->width('60px')
                        ->wrap()
                        ->sortable()
                        ->extraHeaderAttributes(['class' => 'whitespace-normal']),

                    TextColumn::make('pointLog.teacher.teacher_name')
                        ->label('Guru Pencatat')
                        ->grow(false)
                        ->badge()
                        ->color(Color::Taupe)
                        ->numeric()
                        ->width('60px')
                        ->wrap()
                        ->sortable()
                        ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                ])
                ->extraAttributes(['class' => 'baris-log-rata-atas'])
                
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
