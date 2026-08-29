<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Schemas\StudentForm;
use App\Filament\Resources\Students\Schemas\StudentInfolist;
use App\Filament\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;
use UnitEnum;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;  

    protected static ?string $navigationLabel = 'Students';

    protected static string| UnitEnum |null $navigationGroup = 'Akademik';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // dd(auth()->id());
        return StudentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if(auth()->user()->hasRole('teacher')){
            $query->whereHas('classGroup.teacher', function (Builder $query) {
                                $query->where('user_id', auth()->id());
                        });
        }
        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            //'create' => CreateStudent::route('/create'),
            //'view' => ViewStudent::route('/{record}'),
           // 'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}

