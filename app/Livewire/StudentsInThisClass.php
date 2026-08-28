<?php

namespace App\Livewire;

use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class StudentsInThisClass extends TableWidget
{
    public $record;
    
    protected $listeners = ['refreshStudentsList'=> 'refresh'];

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public function table(Table $table): Table
    {
        
        return $table
            ->heading('Member of '.$this->record->class_name)
            ->description('Total: ' . Student::countStudentsInThisClass($this->record->id) . ' students')
            ->query(Student::showStudentsBelongToTheClass($this->record->id))
            ->columns([
                // TextColumn::make('nisn')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('student_name')
                    ->searchable()
                    ->sortable(),
            ])
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
                        $student->removeStudentFromTheClass($student->id);
                        $this->dispatch('refreshStudentsList');
                    })
                    ->tooltip('Remove From This Class')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->size('lg')
                    ->after(function ($livewire) {
                        if ($livewire->getTableRecords()->isEmpty()) {
                            $livewire->previousPage();
                        }
                    }),
            ], position: RecordActionsPosition::AfterCells)
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
