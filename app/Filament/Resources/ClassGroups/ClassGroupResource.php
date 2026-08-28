<?php

namespace App\Filament\Resources\ClassGroups;

use App\Filament\Resources\ClassGroups\Pages\ListClassGroups;
use App\Filament\Resources\ClassGroups\Pages\ManageClassMembers;
use App\Filament\Resources\ClassGroups\Pages\ViewClassGroup;
use App\Filament\Resources\ClassGroups\RelationManagers\StudentsRelationManager;
use App\Filament\Resources\ClassGroups\Schemas\ClassGroupForm;
use App\Filament\Resources\ClassGroups\Schemas\ClassGroupInfolist;
use App\Filament\Resources\ClassGroups\Tables\ClassGroupsTable;
use App\Models\ClassGroup;
use BackedEnum;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ClassGroupResource extends Resource
{
    protected static ?string $model = ClassGroup::class;

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::ChalkboardTeacher;

    protected static ?string $navigationLabel = 'Class';

    protected static string| UnitEnum |null $navigationGroup = 'Akademik';
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return ClassGroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClassGroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClassGroups::route('/'),
            //'create' => CreateClassGroup::route('/create'),
            'view' => ViewClassGroup::route('/{record}'),
            //'edit' => EditClassGroup::route('/{record}/edit'),
            'manage' => ManageClassMembers::route('/{record}/manage'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return 'Class';
        }

        if ($user->hasRole('guru')) {
            return 'Wali Kelas';
        }

        return 'Teacher';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Jika user adalah admin, tampilkan semua. 
        // Jika guru, hanya tampilkan class_group yang miliknya.
        if ($user->hasRole('guru')) {
            return $query->where('form_teacher', $user->teacher->id);
        }

        return $query;
    }
}
