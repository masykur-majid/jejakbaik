<?php

namespace App\Filament\Resources\PointLogs\Tables;

use App\Filament\Resources\PointLogs\PointLogResource;
use App\Models\ConductRule;
use App\Models\Student;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PointLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable()
                    ->dateTime('d M Y'),
                TextColumn::make('subject_type')
                    ->label('Input Berdasarkan')
                    ->searchable()
                    ->formatStateUsing(function (string $state) {
                        $cleanState = class_basename($state); 
                        $lowerState = strtolower($cleanState);

                        return match ($lowerState) {
                            'conductrule', 'conduct' => 'Conduct',
                            'student' => 'Student',
                            default => $state, 
                        };
                    })
                    ->badge()
                    ->icon(function (String $state){
                        $cleanstate = strtolower(class_basename($state));
                        return match($cleanstate){
                            'conductrule', 'conduct' => TablerIcon::Gavel,
                            'student' => Heroicon::UserCircle,
                            default => HeroIcon::InformationCircle,
                        };
                    }),
                TextColumn::make('subject_id')
                    ->label('Subjek')
                    ->sortable()
                    ->state(function ($record){
                        // dd($record->subject);
                        if($record->subject instanceof ConductRule){
                            return $record->subject->conduct_name;
                        }
                        if($record->subject instanceof Student){
                            return $record->subject->student_name;
                        }

                    })
                    ->wrap()
                    ->lineClamp(2),
                TextColumn::make('teacher.teacher_name')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                Action::make('create_by_student')
            ->label('Input Berdasarkan Siswa')
            ->icon('tabler-user')
            ->color(Color::Indigo)
            ->url(PointLogResource::getUrl('create-by-student')),

        Action::make('create_by_conduct')
            ->label('Input Berdasarkan Pelanggaran')
            ->icon('tabler-file-description')
            ->color(Color::Purple)
            ->url(PointLogResource::getUrl('create-by-conduct')),
            ]);
    }
}
