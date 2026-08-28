<?php

namespace App\Filament\Resources\ConductRules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ConductRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->required()
                    ->options([
                        'Achievement' => 'Achievement',
                        'Violation' => 'Violation' 
                    ]),
                TextInput::make('conduct_point')
                    ->required()
                    ->numeric(),
                Textarea::make('conduct_name')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('follow_up_action')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
