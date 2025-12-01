<div class="max-w-4xl mx-auto bg-zinc-50 p-5 rounded-xl shadow space-y-6">
    <div>
        <h1 class="text-2xl font-medium text-zinc-900 dark:text-zinc-100">{{ __('Orders') }}</h1>
        <p class="text-zinc-600 dark:text-zinc-400">{{ __('A list of your recent orders.') }}</p>
    </div>
    <ol class="space-y-4">
        @forelse ($orderItems as $item)
        <li class="grid gap-4 grid-cols-3 p-2 justify-items-center  bg-white rounded-md items-center">
            <img src="{{ $item->variant->product->image->path }}" alt="Order image" class="w-18 h-18 object-cover rounded-lg bg-transparent">
            <p class="text-sm font-normal">{{ $item->description }}</p>
            <p class="text-base font-medium">{{ $item->amount_total }}</p>
        </li>
        @empty
            <p class="mt-4 text-zinc-600 dark:text-zinc-400">{{ __('You have no orders yet.') }}</p>
        @endforelse
    </ol>
</div>
