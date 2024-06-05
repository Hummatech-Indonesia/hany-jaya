<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('purchase_id')->constrained();
            $table->foreignUuid('product_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_unit_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->integer('buy_price_per_unit');
            $table->integer('buy_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_purchases');
    }
};
