<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

   {{-- Filters --}}
    <aside class="hidden lg:col-span-3 lg:block rounded-2xl border border-gray-300 px-4 py-2">

        {{-- Size --}}
        <flux:heading size="lg" heading="2">Size</flux:heading>

        <div class="mt-2 flex flex-col gap-1">
            @foreach ($this->availableSizes as $item)
                <flux:checkbox wire:model.live="sizes" value="{{ $item->size }}" label="{{ $item->size }} ( {{ $item->product_count }} )" />
            @endforeach
        </div>
    </aside>

    <section class="lg:col-span-9">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4">
            @forelse($this->products as $product)
                <article
                    class="border hover:border-gray-800 dark:border-gray-300 hover:dark:border-gray-400 hover:bg-gray-100 hover:dark:bg-zinc-900
                p-4 rounded-2xl transition shadow">
                    <a @class(['flex flex-col gap-2 items-center']) href="{{ route('product.show',[$product->id]) }}">

                        <img loading="lazy" src="{{ $product->previewImageUrl }}" class="mb-3 rounded-2xl" alt="Product Image">
                        <p class="text-xl font-medium">{{ $product->name }}</p>
                        <p class="text-sm dark:text-gray-100">{{ $product->price }}</p>
                    </a>
                </article>
            @empty
                <div class="text-center text-gray-500 py-8">
                    No products found.
                </div>
            @endforelse

            @if ($this->products->hasMorePages())
                <div
                    x-intersect="$wire.loadMore()"
                    class="flex justify-center align-center py-4 transition-opacity"
                >
                    <div class="w-6 h-6 border-2 border-t-slate-500 border-b-slate-500 rounded-full animate-spin"></div>
                </div>
            @endif
        </div>
    </section>

</div>
