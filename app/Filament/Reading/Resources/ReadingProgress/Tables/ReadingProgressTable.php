<?php

namespace App\Filament\Reading\Resources\ReadingProgress\Tables;

use Auth;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class ReadingProgressTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.student_name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->numeric(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'reading' => 'primary',
                        'finished' => 'success',
                        'dropped' => 'gray',
                    }),
                TextColumn::make('current_page')
                    ->numeric(),
                TextColumn::make('started_at')
                    ->date(),
                TextColumn::make('finished_at')
                    ->date()
                    ->placeholder('-'),
                TextColumn::make('reading_logs_count')
                    ->counts('readingLogs')
                    ->label('Logs')
                    ->numeric()
                    ->placeholder('-')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state = 0 => 'danger',  // Sedikit log (merah)
                        $state <= 5 => 'warning', // Lumayan (kuning)
                        default => 'success',     // Rajin (hijau)
                    })
                    ->size('lg')
                    ->suffix(' entri'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->hidden()
                    ->hiddenLabel()
                    ->tooltip(
                        function(){
                            if(Auth::user()->hasRole('siswa')){
                                return 'Reading Log';
                            }
                            return 'View Reading Log';
                        }
                    )
                    ->icon(
                        function(){
                            if(Auth::user()->hasRole('siswa')){
                                return TablerIcon::Plus;
                            }

                            return TablerIcon::TableAlias;
                        }
                    )
                    ->color('info')
                    ->iconSize('lg'),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        
        return $schema
            ->components([
                TextInput::make('reading_progress_id')
                    ->required()
                    ->default(function ($livewire){
                        if(method_exists($livewire, 'getOwnerRecord')){    
                            return $livewire->getOwnerRecord()->current_page;
                        }
                        return 0;
                    })
                    ->dehydrated()
                    ->hidden(),
                DatePicker::make('date_read')
                    ->required()
                    ->default(now())
                    ->dehydrated(),
                TextInput::make('start_page')
                    ->required()
                    ->numeric()
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
                    ->required()
                    ->live(onBlur:true)
                    ->afterStateUpdated(
                        function (Set $set, Get $get){
                            self::calculateTotalPages($set, $get);
                        }
                    )
                    ->numeric()
                    ->dehydrated(),
                TextInput::make('total_page_read')
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->dehydrated()
                    ->reactive(),
                Textarea::make('summary')
                    ->required()
                    ->rows(3)
                    ->autosize()
                    ->columnSpanFull(),
                Toggle::make('verified')
                    ->default(false)
                    ->dehydrated()
                    ->hidden(fn () => Auth::user()->hasRole('siswa')),
                // TextInput::make('teacher_id')
                //     ->default
                       
                //     })
                // ->hidden(fn () => Auth::user()->hasRole('siswa')),
                Textarea::make('teacher_note')
                    ->columnSpanFull()
                    ->disabled(fn () => Auth::user()->hasRole('siswa')),
            ])
            ->columns(1);
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
