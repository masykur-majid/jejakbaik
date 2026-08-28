<?php

namespace App\Filament\Parapoint\Resources\ConductRules\Pages;

use App\Filament\Parapoint\Resources\ConductRules\ConductRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListConductRules extends ListRecords
{
    protected static string $resource = ConductRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                            ->label('Show All'),
            
            'Achievement' => Tab::make('Achievement Point') 
                        ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Achievement'))
                        ->badge($this->getModel()::where('category', 'Achievement')->count())
                        ->icon(Heroicon::PlusCircle),
            
            'Violation' => Tab::make('Violation Point') 
                        ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Violation'))
                        ->badge($this->getModel()::where('category', 'Violation')->count())
                        ->icon(Heroicon::MinusCircle),
        ];
    }
}
