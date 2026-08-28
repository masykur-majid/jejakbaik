<?php

namespace App\Filament\Reading\Resources\Books;

use App\Filament\Reading\Resources\Books\Pages\CreateBook;
use App\Filament\Reading\Resources\Books\Pages\EditBook;
use App\Filament\Reading\Resources\Books\Pages\ListBooks;
use App\Filament\Reading\Resources\Books\Pages\ViewBook;
use App\Filament\Reading\Resources\Books\Schemas\BookForm;
use App\Filament\Reading\Resources\Books\Schemas\BookInfolist;
use App\Filament\Reading\Resources\Books\Tables\BooksTable;
use App\Models\Book;
use BackedEnum;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::Books;

    protected static string| UnitEnum |null $navigationGroup = 'Literasi Pagi';

    public static function form(Schema $schema): Schema
    {
        return BookForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            // 'create' => CreateBook::route('/create'),
            // 'view' => ViewBook::route('/{record}'),
            // 'edit' => EditBook::route('/{record}/edit'),
        ];
    }
}
