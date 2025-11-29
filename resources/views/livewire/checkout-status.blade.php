<div class="px-4 py-2 bg-zinc-100 rounded-md shadow">
    @if ($this->order)
        <p>Thanks for you Order : #{{ $this->order->id }}</p>
    @else
        <div wire:poll.5s>
            <p>Processing your order, please wait...</p>
        </div>
    @endif
</div>
