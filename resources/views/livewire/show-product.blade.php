<div class="grid grid-cols-2 gap-10">
    <div x-data="{ image: '/{{ $this->product->image->path }}' }">
        <img :src="image" class="rounded-2xl transition" alt="{{ $this->product->name }}">
        <div class="grid grid-cols-4 gap-2 mt-4">
            @foreach($this->product->images as $image)
                <img src="/{{ $image->path }}" @click="image = '/{{ $image->path }}'"
                     class="border border-gray-300 rounded-2xl"
                     alt="product image" loading="lazy">
            @endforeach
        </div>
    </div>
    <div>
        <h1 class="text-3xl font-bold">{{ $this->product->name }}</h1>
        <p class="text-xl text-gray-700 dark:text-white">{{ $this->product->price }}</p>
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

            <flux:button variant="primary" wire:click="addToCart">Add to Cart</flux:button>

            <x-action-message class="me-3" on="productAddedToCart">
                {{ __('Product added to your cart.') }}
            </x-action-message>
        </div>


    </div>
</div>
