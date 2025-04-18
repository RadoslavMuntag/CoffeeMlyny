<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('discount_amount', 8, 2);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
