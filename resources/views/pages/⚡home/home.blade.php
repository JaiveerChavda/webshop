<div class="grid grid-cols-4 gap-6">
    @foreach ($this->products as $product)
        <article
            class="border hover:border-gray-800 dark:border-gray-300 hover:dark:border-gray-400 hover:bg-gray-100 hover:dark:bg-zinc-900
        p-4 rounded-2xl transition shadow">
            <a @class(['flex flex-col gap-2 items-center']) href="{{ route('product.show',[$product->id]) }}">

                <img loading="lazy" src="{{ $product->image->path }}" class="mb-3 rounded-2xl" alt="Product Image">
                <p class="text-xl font-medium">{{ $product->name }}</p>
                <p class="text-sm dark:text-gray-100">{{ $product->price }}</p>
            </a>
        </article>
    @endforeach
</div>
