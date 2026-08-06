<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->multiple()
                    ->responsiveImages()
                    ->label('Images'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Repeater::make('variants')
                    ->relationship()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('color')
                                    ->options([
                                        'blue' => 'Blue',
                                        'black' => 'Black',
                                        'white' => 'White',
                                    ])
                                    ->required(),

                                Select::make('size')
                                    ->options([
                                        'S' => 'Small',
                                        'M' => 'Medium',
                                        'L' => 'Large',
                                        'XL' => 'XL',
                                    ])
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
