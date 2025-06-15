<div class="grid grid-cols-4 gap-4 mt-10">
    <div class="bg-zinc-50 p-5 rounded-xl shadow col-span-3">

        <table class="w-full table-auto">
            <thead class="">

                <tr>

                    <th class="text-left">Product</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Color</th>
                    <th class="text-left">size</th>
                    
                    <th class="text-left">Quantity</th>
                    <th class="text-left">Total</th>

                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody class="">
                @forelse ($this->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ $item->variant->color }}</td>
                        <td>{{ $item->variant->size }}</td>

                        <td class="flex items-center gap-4">

                            <flux:button variant="ghost" size="sm" 
                                wire:click="decrement( {{ $item->id }})"
                                :disabled="$item->quantity <= 1"
                            >
                                <flux:icon.minus />
                            </flux:button> 

                            <div>{{ $item->quantity }}</div>

                            <flux:button variant="ghost" size="sm" wire:click="increment( {{ $item->id }})">
                                <flux:icon.plus />
                            </flux:button>
                        </td>
                        <td>{{ $item->subtotal }}</td>
                        <td>
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