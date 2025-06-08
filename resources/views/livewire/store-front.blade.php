<div class="grid grid-cols-4 gap-6">
    @foreach ($this->products as $product)
    <article 
        class="flex flex-col gap-2 items-center 
        border dark:border-gray-300 hover:dark:border-gray-400  
        p-4 rounded-2xl transition shadow-2xl">
        <img src="{{ $product->image->path }}" class="mb-3 rounded-2xl" alt="Product Image">
        <p class="text-xl font-medium">{{ $product->name }}</p>
        <p class="text-sm dark:text-gray-100">{{ $product->price }}</p>
    </article>
    @endforeach
</div>
