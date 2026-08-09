<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use App\Support\MoneyFormatter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Money\Money;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextCOlumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('items_count')
                    ->sortable()
                    ->label('Order Items'),
                TextColumn::make('amount_total')
                    ->label('Amount')
                    ->formatStateUsing(fn (Money $state) => MoneyFormatter::format($state))
                    ->color('warning')
                    ->weight(FontWeight::SemiBold)
                    ->fontFamily(FontFamily::Mono),
                TextColumn::make('created_at')
                    ->dateTime('d M y H:i:s')
                    ->sortable()
                    ->label('Ordered At'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
