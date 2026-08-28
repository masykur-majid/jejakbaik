<?php

namespace App\Filament\Resources\Teachers;

use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Pages\ViewTeacher;
use App\Filament\Resources\Teachers\RelationManagers\StudentsRelationManager;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Schemas\TeacherInfolist;
use App\Filament\Resources\Teachers\Tables\TeachersTable;
use App\Models\Teacher;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;   
    
    protected static ?string $navigationLabel = 'Teacher';
    
    protected static string| UnitEnum |null $navigationGroup = 'Akademik';
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TeacherInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeachers::route('/'),
            // 'create' => CreateTeacher::route('/create'),
            'view' => ViewTeacher::route('/{record}'),
            // 'edit' => EditTeacher::route('/{record}/edit'),
            //'manageMonitoredStudents' => ManageMonitoredStudents::route('/{record}/manage'),
            //'monitor' => MonitoredStudentsManagement::route('/{record}/monitor')
        ];
    }

    //mengatur agar saat guru yang login, hanya data mereka yang muncul   
    public static function getEloquentQuery(): Builder
    {   
        $user = auth()->user();
        
        return parent::getEloquentQuery()
                ->when($user->hasRole('guru'), fn ($query) => $query->where('user_id', $user->id));
    }   

    //mengatur agar navigasi langsung diarahkan ke view
    public static function getNavigationUrl(): String{
        $user = auth()->user();
        if($user->hasRole('guru')){
            $teacherRecord = Teacher::where('user_id', $user->id)->first();

            if($teacherRecord){
                return static::getUrl('view', ['record' => $teacherRecord]);
            }
            
        }
        return parent::getNavigationUrl();
    }

    public static function getNavigationLabel(): string
    {
        $user = auth()->user();

        if ($user->hasRole('guru')) {
            return 'Guru Wali';
        }

        return 'Teacher';
    }

}
