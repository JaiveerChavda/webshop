<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use App\Support\MoneyFormatter;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Money\Money;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Order Details')
                            ->collapsible()
                            ->schema([
                                TextEntry::make('id'),
                                TextEntry::make('amount_total')
                                    ->formatStateUsing(fn (Money $state) => MoneyFormatter::format($state)),
                                TextEntry::make('created_at')
                                    ->dateTime('F j, Y H:i:s')
                                    ->label('Ordered At'),
                                TextEntry::make('stripe_checkout_session_id')
                                    ->fontFamily(FontFamily::Mono)
                                    ->columnSpanFull(),
                                KeyValueEntry::make('shipping_address')
                                    ->state(function (Order $record) {
                                        return $record->shipping_address->toArray();
                                    })
                                    ->columnSpanFull(),
                            ])->columns(3),
                        Section::make('Buyer Info')
                            ->collapsible()
                            ->schema([
                                TextEntry::make('user.name'),
                                TextEntry::make('user.email'),
                            ]),
                    ]),
            ]);
    }
}
