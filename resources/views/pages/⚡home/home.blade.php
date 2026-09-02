<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

    {{-- Filters --}}
    {{-- Desktop --}}
    <aside class="hidden lg:col-span-3 lg:block rounded-2xl border border-gray-300 px-4 py-2">

        {{-- Size --}}
        <flux:heading size="lg" heading="2">Size</flux:heading>

        <div class="mt-2 flex flex-col gap-1">
            @foreach ($this->availableSizes as $item)
                <flux:checkbox wire:model.live="sizes" value="{{ $item->size }}"
                    label="{{ $item->size }} ( {{ $item->product_count }} )" />
            @endforeach
        </div>
    </aside>

    {{-- mobile devices --}}
    <section class="lg:hidden flex order-2 fixed bottom-0 left-0 w-full bg-white px-4 py-2">
        <button class="px-4 py-2 flex-1 flex gap-4 items-center justify-center"
            x-on:click="$flux.modal('filter').show()">
            <flux:icon.funnel class="size-6" />
            {{ __('Filter') }}
        </button>
        <flux:separator vertical class="my-2" />
        <button class="px-4 py-2 flex-1" x-on:click="$flux.modal('sort').show()">{{ __('Sort') }}</button>


        <flux:modal name="filter" flyout position="bottom">
            <div class="h-[50vh] py-4">
                <ul>
                    <li class="flex justify-between items-center py-2 border-b ">
                        <flux:heading size="lg" heading="2">Size</flux:heading>
                        <flux:button variant="ghost" icon="plus" />
                    </li>
                    <li class="flex justify-between items-center py-2 border-b ">
                        <flux:heading size="lg" heading="2">Size</flux:heading>
                        <flux:button variant="ghost" icon="plus" />
                    </li>
                    <li class="flex justify-between items-center py-2 border-b ">
                        <flux:heading size="lg" heading="2">Size</flux:heading>
                        <flux:button variant="ghost" icon="plus" />
                    </li>
                    <li class="flex justify-between items-center py-2 border-b ">
                        <flux:heading size="lg" heading="2">Size</flux:heading>
                        <flux:button variant="ghost" icon="plus" />
                    </li>
                </ul>
            </div>
        </flux:modal>

        <flux:modal name="sort" flyout position="bottom">
            <div class="h-[500px] bg-gray-300">
                <flux:text class="text-center">Sort modal</flux:text>
            </div>
        </flux:modal>
    </section>

    <section class="lg:col-span-9 overflow-y-auto h-dvh">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4">
            @island('products-list')
                @forelse($this->products as $product)
                    <article
                        class="border hover:border-gray-800 dark:border-gray-300 hover:dark:border-gray-400 hover:bg-gray-100 hover:dark:bg-zinc-900
                        p-4 rounded-2xl transition shadow">
                        <a @class(['flex flex-col gap-2 items-center']) href="{{ route('product.show', [$product->id]) }}">

                            <img loading="lazy" src="{{ $product->previewImageUrl }}" class="mb-3 rounded-2xl"
                                alt="Product Image">
                            <p class="text-xl font-medium">{{ $product->name }}</p>
                            <p class="text-sm dark:text-gray-100">{{ $product->price }}</p>
                        </a>
                    </article>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        No products found.
                    </div>
                @endforelse
            @endisland
        </div>


        <div
            x-data="{
                hasMoreProducts: true
            }"
            x-on:no-more-products.document="hasMoreProducts = false"
        >
            <div
                x-show="hasMoreProducts"
                wire:intersect="$wire.loadMore()"
                wire:island.append="products-list"
                class="flex justify-center align-center py-4 transition-opacity"
            >
                <div class="w-6 h-6 border-2 border-t-slate-500 border-b-slate-500 rounded-full animate-spin"></div>
            </div>
            <div
                x-show="! hasMoreProducts"
                class="text-center text-gray-500 py-8">
               You've reached end of the page.
            </div>
        </div>
    </section>
</div>
