<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{

    public int $perPage = 20;

    public array $sizes = [];

    public function loadMore()
    {
        $this->perPage += 10;
    }

    #[Computed()]
    public function availableSizes(): Collection
    {
        return ProductVariant::query()
            ->select('size')
            ->distinct()
            ->orderBy('size')
            ->pluck('size');
    }

    #[Computed()]
    public function Products()
    {
        return Product::query()
            ->with('variants')
            ->when($this->sizes, fn ($query) => $query->whereHas(
                'variants',
                fn ($query) => $query->whereIn('size', $this->sizes)
            ))
            ->paginate(perPage: $this->perPage);
    }
};
