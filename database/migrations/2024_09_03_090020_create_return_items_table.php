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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('selling_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('detail_selling_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('note');
            $table->integer('adjust');
            $table->integer('old_quantity');
            $table->integer('new_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
