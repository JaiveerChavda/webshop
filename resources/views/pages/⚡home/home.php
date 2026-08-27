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
            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
            ->select([
                'product_variants.size',
                DB::raw('COUNT(DISTINCT products.id) AS product_count'),
            ])
            ->groupBy('product_variants.size')
            ->orderBy('product_variants.size')
            ->get();

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
