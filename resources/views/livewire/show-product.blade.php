<div class="grid grid-cols-2 gap-10">
    <div x-data="{ image: '{{ $this->product->original_image_url }}' }">
        <div class="w-full aspect-square overflow-hidden rounded-xl bg-transparent">
            <img :src="image" class="rounded-2xl transition" alt="{{ $this->product->name }}">
        </div>
        <div class="grid grid-cols-4 gap-2 mt-4">
            @forelse($this->product->getMedia() as $media)
            <div class="w-full overflow-hidden aspect-square flex items-center">
                <img src="{{ $media->preview_url }}" @click="image = '{{ $media->original_url }}'"
                     class=" rounded-2xl"
                     alt="product image" loading="lazy">
            </div>
            @empty
                <div>No image exists</div>
            @endforelse
        </div>
    </div>
    <div>
        <h1 class="text-3xl font-bold">{{ $this->product->name }}</h1>
        <p class="text-xl text-gray-700 dark:text-white mt-2">{{ $this->product->price }}</p>
        <p class="mt-4">{!! $this->product->description !!}</p>

        <div @class(['mt-10 space-y-10'])>

            <div>
                <flux:select class="mt-10" wire:model="variant"
                             placeholder="Choose Product Variant...">
                    @foreach($this->product->variants as $variant)
                        <flux:select.option value="{{$variant->id}}">{{$variant->size}}
                            / {{$variant->color}}</flux:select.option>
                    @endforeach
                </flux:select>

                @error('variant')
                <p @class(['text-red-500 text-sm mt-2'])>{{ $message  }}</p>
                @enderror
            </div>

            @if ($this->isVariantAlreadyAddedToCart)
                <flux:button variant="primary" :href="route('cart')" icon="shopping-cart">Go to cart</flux:button>
            @else
                <flux:button variant="primary" wire:click="addToCart">Add to Cart</flux:button>
            @endif
        </div>
    </div>
</div>
