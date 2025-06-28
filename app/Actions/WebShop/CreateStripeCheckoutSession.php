<?php

namespace App\Actions\WebShop;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CreateStripeCheckoutSession
{
    public function createFromCart(Cart $cart)
    {
        return $cart->user
            ->allowPromotionCodes()
            ->checkout(
                $this->formatCartItems($cart->items),
                [
                    'customer_update' => [
                        'address' => 'auto',
                    ],
                    'shipping_address_collection' => [
                        'allowed_countries' => ['US', 'NL', 'IN'],
                    ],
                ]
            );
    }

    private function formatCartItems(Collection $items): array
    {
        $items->loadMissing('product');

        return $items->map(function (CartItem $item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item->product->price->getAmount(),
                    'product_data' => [
                        'name' => $item->product->name,
                        'description' => "Size: {$item->variant->size} - Color : {$item->variant->color} ",
                        'metadata' => [
                            'product_id' => $item->product->id,
                            'variant_id' => $item->product_variant_id,
                        ],
                    ],
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();
    }
}
