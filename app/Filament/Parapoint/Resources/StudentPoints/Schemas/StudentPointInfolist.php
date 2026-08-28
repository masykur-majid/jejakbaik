<?php

namespace App\Filament\Parapoint\Resources\StudentPoints\Schemas;

use App\Models\PointLogDetail;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Point Summary')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('current_points')
                            ->label('Current Point')
                            ->badge()
                            ->size('xl'),
                        TextEntry::make('Violation Point')
                            ->badge()
                            ->color('danger')
                            ->state(function ($record){
                                return PointLogDetail::where('student_id', $record->id)
                                    ->whereHas('conductRule', fn($q) => $q->where('category', 'Violation'))
                                    ->sum('counted_point');
                            }),
                        TextEntry::make('Achievement Point')
                            ->badge()
                            ->color('success')
                            ->state(function ($record){
                                return PointLogDetail::where('student_id', $record->id)
                                    ->whereHas('conductRule', fn($q) => $q->where('category', 'Achievement'))
                                    ->sum('counted_point');
                            }),
                    ]),
                    
            ])
            ->columns(1);
    }
}

