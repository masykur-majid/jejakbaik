<?php

namespace App\Filament\Reading\Resources\Books\Pages;

use App\Filament\Reading\Resources\Books\BookResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
}
