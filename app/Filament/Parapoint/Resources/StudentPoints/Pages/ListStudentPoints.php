<?php

namespace App\Filament\Parapoint\Resources\StudentPoints\Pages;

use App\Filament\Parapoint\Resources\PointLogs\PointLogResource;
use App\Filament\Parapoint\Resources\StudentPoints\StudentPointResource;
use App\Models\PointLogDetail;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListStudentPoints extends ListRecords
{
    protected static string $resource = StudentPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_by_student')
            ->label('By Student')
            ->icon('tabler-user')
            ->color(Color::Indigo)
            ->url(PointLogResource::getUrl('create-by-student')),

        Action::make('create_by_conduct')
            ->label('By Conduct')
            ->icon('tabler-file-description')
            ->color(Color::Purple)
            ->url(PointLogResource::getUrl('create-by-conduct')),

        Action::make('add_default_point')
            ->label('Assign Default point')
            ->icon('tabler-file-description')
            ->color(Color::Zinc)
            ->requiresConfirmation()
            ->modalDescription('Yakin ingin untuk memberikan point 150 ke siswa dengan data null?')
            ->action(function(){
                $setPoint = Student::query()
                                ->whereNull('current_points')
                                ->update(['current_points' => 150]);
                
                Notification::make()
                    ->title("{$setPoint} student(s) assigned 15 point")
                    ->success()
                    ->send();

                
            }),
        ];
    }
    
}
