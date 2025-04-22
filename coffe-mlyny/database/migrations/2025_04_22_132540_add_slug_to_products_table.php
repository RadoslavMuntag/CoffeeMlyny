<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });
    
        \App\Models\Product::all()->each(function ($product) {
            $product->slug = \Illuminate\Support\Str::slug($product->name . '-' . $product->variant);
            $product->save();
        });
    
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }
    

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
};
