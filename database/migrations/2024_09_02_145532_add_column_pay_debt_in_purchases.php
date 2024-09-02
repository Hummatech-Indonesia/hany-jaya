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
        if(!Schema::hasColumn('purchases','pay_date')){
            Schema::table('purchases', function (Blueprint $table) {
                $table->date('pay_date')->nullable();
            });
        }

        if(!Schema::hasColumn('purchases','status')){
            Schema::table('purchases', function (Blueprint $table) {
                $table->string('status')->nullable();
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
