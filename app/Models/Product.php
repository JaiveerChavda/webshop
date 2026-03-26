<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;
use Money\Currency;
use Money\Money;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,InteractsWithMedia;

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected function price(): Attribute
    {
        // 1st way
        // return Attribute::make(
        //     get: function (int $value) {
        //         return Number::currency($value / 100,'USD');
        //     }
        // );

        // 2nd way
        return Attribute::make(
            get: function (int $value) {
                return new Money($value, new Currency('USD'));
            }
        );
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function previewImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getFirstMedia()['preview_url'];
            }
        );
    }
}
