<?php

namespace App\Filament\Resources\StudentPoints\Pages;

use App\Filament\Resources\StudentPoints\StudentPointResource;
use App\Models\PointLogDetail;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ViewStudentPoint extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = StudentPointResource::class;

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return "{$record->student_name} :: {$record->classGroup->class_name}";
    }
    
    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
   
}
