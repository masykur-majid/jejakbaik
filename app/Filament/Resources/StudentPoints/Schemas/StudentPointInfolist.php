<?php

namespace App\Filament\Resources\StudentPoints\Schemas;

use App\Models\PointLogDetail;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Livewire\Attributes\On;

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
                            ->label('Sisa Poin')
                            ->color(function ($record){
                                $points = $record->current_points;
                                if($points >=101 )return Color::Emerald;
                                elseif($points <= 100 && $points >=51) return Color::Yellow;
                                elseif($points <= 50) return Color::Red;
                                elseif($points <= 0) return Color::Neutral;
                            })
                            ->weight('semibold')
                            ->extraAttributes(['class' => 'point-large']),
                        TextEntry::make('Violation Point')
                            ->color(Color::Rose)
                            ->weight('semibold')
                            ->extraAttributes(['class' => 'point-large'])
                            ->state(function ($record){
                                return PointLogDetail::where('student_id', $record->id)
                                    ->whereHas('conductRule', fn($q) => $q->where('category', 'Violation'))
                                    ->sum('counted_point');
                            }),
                        TextEntry::make('Achievement Point')
                            ->color(Color::Green)
                            ->weight('semibold')
                            ->extraAttributes(['class' => 'point-large'])
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
