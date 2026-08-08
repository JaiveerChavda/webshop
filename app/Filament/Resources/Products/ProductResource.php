<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\ViewProduct;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use App\Support\MoneyFormatter;
use BackedEnum;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Money\Money;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
            'view' => ViewProduct::route('/{record}'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(4)
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Product Information')
                            ->icon(Heroicon::OutlinedRectangleStack)
                            ->description('Detailed information about the product')
                            ->collapsible()
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                                Infolists\Components\TextEntry::make('description'),
                                Infolists\Components\ImageEntry::make('original_image_url')
                                    ->label('Product Images'),
                            ])
                            ->columnSpan(['default' => 3]),
                        Section::make('Pricing & Features')
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->description('Information about pricing & features')
                            ->collapsible()
                            ->schema([
                                Infolists\Components\TextEntry::make('price')
                                    ->formatStateUsing(fn (Money $state) => MoneyFormatter::format($state))
                                    ->size(TextSize::Medium)
                                    ->color(Color::Amber)
                                    ->weight(FontWeight::SemiBold),

                                Infolists\Components\TextEntry::make('colors')
                                    ->label('Colors')
                                    ->state(fn (Product $record) => $record->variants
                                        ->pluck('color')
                                        ->implode(', ')),

                                Infolists\Components\TextEntry::make('sizes')
                                    ->label('Available sizes')
                                    ->state(fn (Product $record) => $record->variants
                                        ->pluck('size')
                                        ->implode(', ')),
                            ]),
                    ]),
            ]);
    }
}
