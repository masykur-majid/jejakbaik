<?php

namespace App\Filament\Resources\ClassGroups\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClassGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('class_name')
                    ->required(),
                Select::make('code_of_vocation')
                    ->relationship('vocation', 'vocation_name'),
                Select::make('form_teacher')
                    ->relationship('teacher', 'teacher_name'),
            ])
            ->columns(1);
    }
}
