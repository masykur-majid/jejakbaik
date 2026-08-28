<?php

namespace App\Filament\Resources\ClassGroups\Pages;

use App\Filament\Resources\ClassGroups\ClassGroupResource;
use App\Livewire\StudentNotInThisClass;
use App\Livewire\StudentsInThisClass;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageClassMembers extends EditRecord
{

    //who can access it
    public static function canAccess(array $parameters = []): bool
    {
        $record = $parameters['record'] ?? null;

        if (! $record) {
            return false;
        }

        // Memanggil method 'manageMembers' yang ada di ClassGroupPolicy
        return auth()->user()->can('manage', $record);
    }

    protected static string $resource = ClassGroupResource::class;
    
    protected static ?string $title = "Manage Class Members";

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Class Information")
                    ->icon(Heroicon::InformationCircle)
                    ->schema([
                        TextInput::make('class_name')
                            ->required(),
                        Select::make('code_of_vocation')
                            ->relationship('vocation', 'vocation_name'),
                        Select::make('form_teacher')
                            ->relationship('teacher','teacher_name'),
                        Actions::make([
                            Action::make('save')
                                ->label('Update Class Information')
                                ->color('primary')
                                ->icon(TablerIcon::DeviceFloppyFilled)
                                ->action('save')
                        ])  
                        ->columnSpanFull()
                        ->alignEnd()
                    ])
                    ->columns(3),

                Section::make("Add/Remove Class Mambers")
                    ->icon(TablerIcon::ReplaceUser)
                    ->description('Add or remove students as the member of this class. The add/remove process will be saved directly, you didn\'t need to press any button.')
                    ->schema([
                        Livewire::make(StudentsInThisClass::class, ['record'=>$this->record])->key('student-members'),
                        Livewire::make(StudentNotInThisClass::class, ['record'=>$this->record])->key('not-member')
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // StudentsInThisClass::make(['record'=>$this->record]),
            // StudentNotInThisClass::make(['record'=>$this->record]),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
