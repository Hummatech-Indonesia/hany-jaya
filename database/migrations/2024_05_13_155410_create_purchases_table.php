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
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->restrictOnUpdate()->cascadeOnUpdate();
            $table->foreignUuid('product_id')->constrained()->restrictOnUpdate()->cascadeOnUpdate();
            $table->foreignUuid('supplier_id')->constrained()->restrictOnUpdate()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->integer('buy_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
