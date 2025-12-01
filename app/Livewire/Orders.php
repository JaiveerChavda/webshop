<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Orders extends Component
{
    public Collection $orderItems;

    public function mount()
    {
        $this->orderItems = auth()->user()->orderItems()->latest()->get();
    }
    public function render()
    {
        return view('livewire.orders');
    }
}
