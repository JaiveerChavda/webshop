<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $money = $data['price'];
        info($money->getAmount());
        $data['price'] = $money->getAmount() / 100;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // convert in cents.
        $data['price'] = $data['price'] * 100;

        return $data;
    }
}
