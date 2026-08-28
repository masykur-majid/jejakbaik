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

class StudentNotInThisClass extends TableWidget
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
            ->heading('Other Students')
            ->description('Total: ' . Student::countStudentsNotInThisClass($this->record->id) . ' students')
            ->query(Student::showStudentsDoNotBelongToTheClass($this->record->id))
            
            
            ->columns([
                TextColumn::make('student_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classgroup.class_name')
                    ->searchable()
                    ->sortable(),
            ])


            ->filters([
                TernaryFilter::make('show_student_that')
                    ->label('Show students who')
                    ->placeholder('IN other and NOT IN a class')
                    ->trueLabel('haven\'t got into a class')
                    ->falseLabel('is in the other Class')
                    ->queries(
                        true: fn (Builder $query) => $query->doesntHave('classgroup'),
                        false: fn (Builder $query) => $query->has('classgroup'),
                    )
            ], layout: FiltersLayout::AfterContentCollapsible)
            ->filtersResetActionPosition(FiltersResetActionPosition::Footer)
            ->filtersFormColumns(1)


            ->headerActions([
                //
            ])


            ->recordActions([
                Action::make('Add')
                    ->badge()
                    ->extraAttributes(['class' => 'inline-block m-2 p-2'])
                    ->action(function (Student $student){
                        Student::AddStudentToTheClass($student->id, $this->record->id);
                        $this->dispatch('refreshStudentsList');
                    })
                    ->hiddenLabel()
                    ->tooltip('Add to This Class')
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->color('success')
                    ->size('lg')
                    ->after(function ($livewire) {
                        if ($livewire->getTableRecords()->isEmpty()) {
                            $livewire->previousPage();
                        }
                    }),
                    
                ], position: RecordActionsPosition::AfterColumns)


            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
