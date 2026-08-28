<?php

namespace App\Livewire;

use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\FiltersResetActionPosition;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class StudentsMonitoredNotByThisTeacher extends TableWidget
{
    public $record;

    protected $listeners = ['refreshStudentsList' => 'refresh'];

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->heading('Tambah Siswa Binaan')
            ->description('Total: '. Student::countStudentsMonitoredNotByThisTeacher($this->record->id).' students')
            ->query(Student::query()->showStudentsMonitoredNotByThisTeacher($this->record->id))
            ->columns([
                TextColumn::make('student_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classGroup.class_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('teacher_id')
                    ->searchable()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('updated_at')
                    ->hidden(),
            ])
            ->defaultSort('updated_at', 'desc')
            
            ->filters([
                
                 // TernaryFilter::make('show_student_that')
                //     ->label('Show students who')
                //     ->placeholder('both haven\'t got any mentor and with other mentor')
                //     ->trueLabel('haven\'t got a mentor teacher')
                //     ->falseLabel('is with the other mentor teacher')
                //     ->queries(
                //         true: fn (Builder $query) => $query->doesntHave('teacher'),
                //         false: fn (Builder $query) => $query->has('teacher'),
                //     )
            ])
            // ->filtersResetActionPosition(FiltersResetActionPosition::Footer)
            // ->filtersFormColumns(1)
            

            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('Add')
                    ->badge()
                    ->extraAttributes(['class' => 'inline-block m-2 p-2'])
                    ->action(function (Student $student){
                        $student->addMonitoredStudent($student->id, $this->record->id);
                        
                        $this->dispatch('refreshStudentsList');
                    })
                    ->hiddenLabel()
                    ->tooltip('Add to This Class')
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->color('success')
                    ->size('lg')
                    
            ], position: RecordActionsPosition::AfterColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}