<?php

namespace App\Filament\Imports;

use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nisn')
                ->rules(['max:255']),
            ImportColumn::make('nis')
                ->rules(['max:255']),
            ImportColumn::make('student_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('current_grade')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('classGroup')
                ->relationship(),
            ImportColumn::make('teacher')
                ->relationship(),
            ImportColumn::make('current_point')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),
            ImportColumn::make('current_points')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),
        ];
    }

    public function resolveRecord(): Student
    {
        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
