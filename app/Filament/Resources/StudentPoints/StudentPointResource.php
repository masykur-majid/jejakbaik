<?php

namespace App\Filament\Resources\StudentPoints;

use App\Filament\Resources\StudentPoints\Pages\ListStudentPoints;
use App\Filament\Resources\StudentPoints\Pages\ViewStudentPoint;
use App\Filament\Resources\StudentPoints\RelationManagers\PointLogDetailsRelationManager;
use App\Filament\Resources\StudentPoints\Schemas\StudentPointForm;
use App\Filament\Resources\StudentPoints\Schemas\StudentPointInfolist;
use App\Filament\Resources\StudentPoints\Tables\StudentPointsTable;
use App\Models\Student;
use BackedEnum;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class StudentPointResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $slug = 'student-point';

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::Stars;
    protected static string | BackedEnum | null $activeNavigationIcon = TablerIcon::StarsFilled;

    
    
    protected static ?string $navigationLabel = 'Lihat Poin Siswa';
 
    protected static ?string $pluralLabel = 'Daftar Poin Siswa';
 
    protected static ?string $modelLabel = 'Student Point';
    
    public static function form(Schema $schema): Schema
    {
        return StudentPointForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentPointInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentPointsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PointLogDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentPoints::route('/'),
            'view' => ViewStudentPoint::route('/{record}'),
        ];
    }

    // Limit Shield permissions — no create/delete here
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'update',
        ];
    }

    // Override route key so view page resolves correctly
    public static function getRecordRouteKeyName(): string
    {
        return 'id';
    }
}
