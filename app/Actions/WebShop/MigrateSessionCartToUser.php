<?php

namespace App\Actions\WebShop;

use App\Models\Cart;
use App\Models\CartItem;

class MigrateSessionCartToUser
{
    public static function migrate(Cart $sessionCart, Cart $userCart)
    {
        $sessionCart->items->each(function (CartItem $item) use ($userCart) {

            $item->update([
                'cart_id' => $userCart->id,
            ]);
        });

        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}
