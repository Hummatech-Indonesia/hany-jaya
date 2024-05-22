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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('outlet_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
