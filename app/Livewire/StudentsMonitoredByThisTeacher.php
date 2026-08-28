<?php

namespace App\Livewire;

use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class StudentsMonitoredByThisTeacher extends TableWidget
{
    public $record;

    protected $listeners = ['refreshStudentsList' => 'refresh'];
    
     public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
    
    public function table(Table $table): Table
    {
        // dd($this->record);
        return $table
            ->heading('Siswa Binaan')
            ->description('Total: ' . Student::countStudentsMonitoredByThisTeacher($this->record->id) . ' students')
            ->extraAttributes([
                'class' => '[&_.fi-ta-search-field]:!w-full [&_.fi-ta-search-field]:!max-w-none',
            ])
            
            ->query(Student::query()->showStudentsMonitoredByThisTeacher($this->record->id))

            ->columns([
                TextColumn::make('student_name')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->hidden(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('Remove')
                    ->badge()
                    ->action(function (Student $student){
                        $student->removeMonitoredStudent($student->id);
                        
                        $this->dispatch('refreshStudentsList');
                    })
                    ->tooltip('Remove From This Class')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->size('lg')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
