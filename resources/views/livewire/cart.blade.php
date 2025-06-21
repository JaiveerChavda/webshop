<div class="grid grid-cols-4 gap-4 mt-10">
    <div class="bg-zinc-50 p-5 rounded-xl shadow col-span-3">

        <table class="w-full table-auto">
            <caption>
                <h2>Your Cart</h2>
            </caption>
            <th class="text-left">Product</th>
            <th class="text-left">Price</th>
            <th class="text-left">Color</th>
            <th class="text-left">size</th>
            <th class="text-center" width="100">Quantity</th>
            <th class="text-right">Total</th>
            <th>&nbsp;</th>
            <tbody class="">
                @forelse ($this->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ $item->variant->color }}</td>
                        <td>{{ $item->variant->size }}</td>

                        <td>
                            <div class="flex items-center gap-4">
                                <flux:button variant="ghost" size="sm" wire:click="decrement( {{ $item->id }})"
                                    :disabled="$item->quantity <= 1">
                                    <flux:icon.minus />
                                </flux:button>

                                <div>{{ $item->quantity }}</div>

                                <flux:button variant="ghost" size="sm" wire:click="increment( {{ $item->id }})">
                                    <flux:icon.plus />
                                </flux:button>
                            </div>


                        </td>
                        <td align="right">{{ $item->subtotal }}</td>
                        <td align="right">
                            <flux:button variant="ghost" size="sm" wire:click="delete( {{ $item->id }})">
                                <flux:icon.trash />
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center sm:text-2xl">Your Cart is empty</td>
                    </tr>
                @endforelse
                <tr>
                    <td align="right" colspan="6"> <span class="font-bold font-mono">Total</span> {{ $this->total }}</td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class=" col-span-1">
        <div class="bg-zinc-50 p-5 rounded-xl shadow">
            @guest
                please register or login to continue
            @endguest

            @auth
                <flux:button variant="primary" size="sm" wire:click="checkout">
                    Continue Checkout
                </flux:button>
            @endauth
        </div>
    </div>
</div>