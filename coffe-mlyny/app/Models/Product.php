<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'variant',
        'weight',
        'price',
        'stock',
        'description',
        'category_id',
        'featured',
        'slug'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'featured' => 'boolean',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->generateSlug();
        });

        static::updating(function ($product) {
            if ($product->isDirty(['name', 'variant', 'weight'])) {
                $product->generateSlug();
            }
        });
    }

    /**
     * Generate a slug for the product.
     *
     * @return void
     */
    protected function generateSlug(): void
    {
        $this->slug = Str::slug($this->name . '-' . $this->variant . '-' . $this->weight);
    }

    /**
     * Get the images for the product.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get the cart items for the product.
     *
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the reviews for the product.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
