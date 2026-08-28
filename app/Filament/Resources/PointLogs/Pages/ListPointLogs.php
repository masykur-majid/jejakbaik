<?php

namespace App\Filament\Resources\PointLogs\Pages;

use App\Filament\Resources\PointLogs\PointLogResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;

class ListPointLogs extends ListRecords
{
    protected static string $resource = PointLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
        Action::make('create_by_student')
            ->label('By Student')
            ->icon('tabler-user')
            ->color(Color::Indigo)
            ->url(PointLogResource::getUrl('create-by-student')),

        Action::make('create_by_conduct')
            ->label('By Conduct')
            ->icon('tabler-file-description')
            ->color(Color::Purple)
            ->url(PointLogResource::getUrl('create-by-conduct')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                            ->label('Show All'),
            
            'Conduct' => Tab::make('Log By Conduct'),
                        // ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Achievement'))
                        // ->badge($this->getModel()::where('category', 'Achievement')->count())
                        // ->icon(Heroicon::PlusCircle),
            
            'Student' => Tab::make('Log By Student') 
                        // ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Violation'))
                        // ->badge($this->getModel()::where('category', 'Violation')->count())
                        // ->icon(Heroicon::MinusCircle),
        ];
    }
}
