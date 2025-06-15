<div class="bg-zinc-50 mt-10 p-5 rounded-xl shadow">
    
    <table class="w-full table-auto">
        <thead class="">
            <th class="text-left">Product</th>
            <th class="text-left">Quantity</th>
        </thead>
        <tbody class="">
            @forelse ($this->items as $item)
                <tr>
                    <td>{{ $item->product->name }} size: {{ $item->variant->size }} color: {{ $item->variant->color }}</td>
                    <td class="flex items-center gap-4">
                        
                        <flux:button variant="ghost" 
                            size="sm" 
                            wire:click="decrement( {{ $item->id }})" 
                            :disabled="$item->quantity <= 1"                           
                        >
                            <flux:icon.minus />
                        </flux:button>
                        
                        <div>{{ $item->quantity }}</div>
                        
                        <flux:button variant="ghost" 
                            size="sm" 
                            wire:click="increment( {{ $item->id }})"
                        >
                            <flux:icon.plus />
                        </flux:button>
                    </td>
                    <td>
                        <flux:button variant="ghost" size="sm" wire:click="delete( {{ $item->id }})"><flux:icon.trash /></flux:button>
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
