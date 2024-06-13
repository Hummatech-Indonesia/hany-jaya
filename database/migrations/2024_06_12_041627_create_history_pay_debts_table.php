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
        Schema::create('history_pay_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('pay_debt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pay_debts');
    }
};
