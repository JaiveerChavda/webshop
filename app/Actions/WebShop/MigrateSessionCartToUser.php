<?php

namespace App\Actions\WebShop;

use App\Models\Cart;
use App\Models\CartItem;

class MigrateSessionCartToUser
{
    /**
     * @return Cart $userCart
     */
    public static function migrate(Cart $sessionCart, Cart $userCart): Cart
    {
        $sessionCart->items->each(function (CartItem $item) use ($userCart) {

            $item->update([
                'cart_id' => $userCart->id,
            ]);
        });

        $sessionCart->delete();

        $userCart->load('items');

        return $userCart;
    }
}
