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
        if(!Schema::hasColumn('history_pay_debts','desc')){
            Schema::table('history_pay_debts', function (Blueprint $table) {
                $table->string('desc')->nullable();
            });
        }
        if(!Schema::hasColumn('debts','paid_off')){
            Schema::table('debts', function (Blueprint $table) {
                $table->tinyInteger('paid_off')->default(0);
            });
        }
        if(!Schema::hasColumn('debts','remind_debt')){
            Schema::table('debts', function (Blueprint $table) {
                $table->integer('remind_debt')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
