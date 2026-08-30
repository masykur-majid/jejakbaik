<?php

namespace App\Filament\Resources\PointLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PointLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('subject_type')
                    ->label('Input Berdasarkan:')
                    ->formatStateUsing(fn (string $state): string => class_basename($state)=='Student' ? 'Siswa' : 'Perilaku')
                    ->badge(),
                TextEntry::make('teacher.teacher_name')
                    ->label('Dibuat Oleh:'),
                TextEntry::make('created_at')
                    ->label('Dibuat pada:')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('subject_name')
                    ->label(fn ($record) => match (class_basename($record->subject_type)) {
                        'Student' => 'Nama Siswa',
                        'ConductRule' => 'Aturan Perilaku',
                        default => 'siubject',
                    })
                    ->columnSpan(2)
                    ->wrap()
                    ->badge()
                    ->numeric(),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ])
            ->columns(3);
    }
}
