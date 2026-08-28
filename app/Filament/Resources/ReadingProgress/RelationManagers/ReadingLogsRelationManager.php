<?php

namespace App\Filament\Resources\ReadingProgress\RelationManagers;

use App\Filament\Resources\ReadingProgress\Pages\ViewReadingProgress;
use Auth;
use Closure;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReadingLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'readingLogs';
    
    public function isReadOnly(): bool
    {
        return false;
    }
    
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }

    public function form(Schema $schema): Schema
    {
        
        return $schema
            ->components([
                TextInput::make('reading_progress_id')
                    ->rules(['required'])
                    ->default(function ($livewire){
                        if(method_exists($livewire, 'getOwnerRecord')){    
                            return $livewire->getOwnerRecord()->current_page;
                        }
                        return 0;
                    })
                    ->dehydrated()
                    ->hidden(),
                
                DatePicker::make('date_read')
                    ->rules(['required'])
                    ->default(now())
                    ->dehydrated(),

                TextInput::make('start_page')
                    ->numeric()
                    ->rules(['required'])
                    ->live(onBlur:true)
                    ->default(function ($livewire){
                        if(method_exists($livewire, 'getOwnerRecord')){    
                            return $livewire->getOwnerRecord()->current_page;
                        }
                        return 0;
                    })
                    ->afterStateUpdated(
                        function (Set $set, Get $get){
                            self::calculateTotalPages($set, $get);
                        }
                    )
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('end_page')
                    ->numeric()
                    ->live(debounce: 300)
                    ->afterStateUpdated(
                        function ($livewire, $component, Set $set, Get $get){
                            self::calculateTotalPages($set, $get);
                            $livewire->validateOnly($component->getStatePath());
                        }
                    )
                    ->rules([
                        'required',
                        fn ($livewire) => function (string $attribute, $value, Closure $fail) use ($livewire){
                            $maxPages=$livewire->getOwnerRecord()->book->total_pages;
                            if ($value > $maxPages){
                                $fail("Halaman jangan melebihi {$maxPages}!");
                            }
                        }
                     ])
                    ->dehydrated(),
                    
                TextInput::make('total_page_read')
                    ->rules(['required'])
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->dehydrated()
                    ->reactive(),

                Textarea::make('summary')
                    ->rules(['required'])
                    ->rows(3)
                    ->autosize()
                    ->columnSpanFull(),
                
                Toggle::make('verified')
                    ->default(false)
                    ->dehydrated()
                    ->hidden(fn () => Auth::user()->hasRole('siswa')),
                TextInput::make('teacher_id')
                    ->default(
                        fn () => auth()->user()->teacher->teacher_name
                    ),
                Textarea::make('teacher_note')
                    ->columnSpanFull()
                    ->disabled(fn () => Auth::user()->hasRole('siswa')),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Reading Logs')
            ->description('Klik tombbol (+ New Reading Log) untuk menambahkan catatan aktivitas membaca kalian')
            ->columns([
                TextColumn::make('readingProgress.id')
                    ->searchable()
                    ->hidden(),
                TextColumn::make('date_read')
                    ->date(),
                TextColumn::make('start_page')
                    ->numeric()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('total_page_read')
                    ->numeric()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                TextColumn::make('end_page')
                    ->numeric()
                    ->extraHeaderAttributes(['class' => 'whitespace-normal']),
                IconColumn::make('verified')
                    ->boolean()
                    ->falseIcon(Heroicon::XCircle)
                    ->falseColor('danger')
                    ->trueIcon(Heroicon::CheckBadge)
                    ->trueColor('success')
                    ->tooltip(fn ($record) => $record->verified 
                        ? "Oleh: {$record->teacher?->name}" 
                        : 'Menunggu validasi guru'),
                TextColumn::make('summary')
                    ->numeric()
                    ->wrap()
                    ->words(10)
                    ->lineClamp(2),
                TextColumn::make('teacher_note')
                    ->numeric()
                    ->wrap()
                    ->width('20%')
                    ->lineClamp(2),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date_read', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                //ViewAction::make(),
                EditAction::make()
                    ->label(function (){
                        if(Auth::user()->hasRole('siswa')){
                            return 'Revise';
                        }
                        return 'Review & Verify';
                    })
                    ->slideOver()
                    ->modalWidth('md')
                    ->after(fn ($livewire) => $livewire->dispatch('refreshReadingProgress')),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->after(fn ($livewire) => $livewire->dispatch('refreshReadingProgress')),
                ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->modalWidth('md')
                    ->after(fn ($livewire) => $livewire->dispatch('refreshReadingProgress'))
            ]);
    }

    public static function calculateTotalPages(Set $set, Get $get): void
    {
        $start = (int) $get('start_page');
        $end = (int) $get('end_page');

        if ($end >= $start) {
            $set('total_page_read', $end - $start + 1);
        } else {
            $set('total_page_read', 0);
        }
    }
}
