<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Support\MoneyFormatter;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Money\Currency;
use Money\Money;

class OrderItemsTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public Order $order;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->order->items()->getQuery())
            ->columns([
                TextColumn::make('name')
                    ->label('Product'),

                TextColumn::make('description'),

                TextColumn::make('price')
                    ->formatStateUsing(fn (Money $state) => MoneyFormatter::format($state)),

                TextColumn::make('quantity')
                    ->alignCenter(),

                TextColumn::make('amount_total')
                ->label('Total')
                    ->formatStateUsing(fn (Money $state) => MoneyFormatter::format($state))
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(
                                fn ($state) => MoneyFormatter::format(
                                    new Money($state, new Currency('USD'))
                                )
                            )
                    ),

            ]);
    }

    public function render()
    {
        return view('livewire.admin.orders.order-items-table');
    }
}
