<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name . '-' . $product->variant . '-' . $product->weight);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name . '-' . $product->variant . '-' . $product->weight);
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}