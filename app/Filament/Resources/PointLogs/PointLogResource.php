<?php

namespace App\Filament\Resources\PointLogs;

use App\Filament\Resources\PointLogs\Pages\CreateByConduct;
use App\Filament\Resources\PointLogs\Pages\CreateByStudent;
use App\Filament\Resources\PointLogs\Pages\InputForWholeClass;
use App\Filament\Resources\PointLogs\Pages\ListPointLogs;
use App\Filament\Resources\PointLogs\Pages\ViewPointLog;
use App\Filament\Resources\PointLogs\Schemas\PointLogInfolist;
use App\Filament\Resources\PointLogs\Tables\PointLogsTable;
use App\Filament\Resources\StudentPoints\RelationManagers\PointLogDetailsRelationManager as RelationManagersPointLogDetailsRelationManager;
use App\Models\PointLog;
use BackedEnum;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;

class PointLogResource extends Resource
{
    protected static ?string $model = PointLog::class;

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::ListDetailsFilled;

    protected static ?string $navigationLabel = 'Input Poin';

    protected static ?string $pluralLabel = 'Input Poin';

    public static function infolist(Schema $schema): Schema
    {
        return PointLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PointLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagersPointLogDetailsRelationManager::class,
        ];
    }


    #[Override]
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if(auth()->user()->hasRole('teacher')){
            $query->where('teacher_id', function ($subquery) {
                                $subcquery->select('id')
                                    ->from('teachers')
                                    ->where('user_id', auth()->id())
                                    ->limit(1);
                        });
        }
        return $query;
    }
 

    public static function getPages(): array
    {
        return [
            'index' => ListPointLogs::route('/'),
            'create-by-student' => CreateByStudent::route('/create/by-student'),
            'create-by-conduct' => CreateByConduct::route('/create/by-conduct'),
            'mass-input' => InputForWholeClass::route('/mass-input'),
            'view' => ViewPointLog::route('/{record}'),
            
            // 'edit-by-student' => CreateByStudent::route('/{record}/edit/by-student'),
            // 'edit-by-conduct' => CreateByConduct::route('/{record}/edit/by-conduct'),
        ];
    }

    
}