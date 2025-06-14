<div>
    <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
        {{-- <flux:icon.shopping-cart /> --}}
        <flux:navbar.item href="{{ route('cart') }}" icon="shopping-cart" badge="0">Cart ( {{ $this->count }} )</flux:navbar.item>
    </flux:navbar>
</div>