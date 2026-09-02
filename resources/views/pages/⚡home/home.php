<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{

    const LIMIT = 20;

    public int $offset = 0;

    public array $sizes = [];

    public function loadMore()
    {
        $this->offset += self::LIMIT;

        if($this->products->count() < self::LIMIT){
            $this->dispatch('no-more-products');
        }
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
    public function products()
    {
        return Product::query()
            ->with('variants','media')
            ->when($this->sizes, fn ($query) => $query->whereHas(
                'variants',
                fn ($query) => $query->whereIn('size', $this->sizes)
            ))
            ->limit(self::LIMIT)
            ->offset($this->offset)
            ->get();
    }

    #[Computed()]
    public function hasMoreProducts(): bool
    {
        return $this->products->count() === 20;
    }
};
