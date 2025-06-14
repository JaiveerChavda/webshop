<div class="bg-zinc-50 mt-10 p-5 rounded-xl shadow">
    
    <table class="w-full">
        <thead class="">
            <th class="text-left">Product</th>
            <th class="text-left">Quantity</th>
        </thead>
        <tbody class="">
            @forelse ($this->items as $item)
                <tr>
                    <td>{{ $item->product->name }} size: {{ $item->variant->size }} color: {{ $item->variant->color }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center sm:text-2xl">Your Cart is empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
