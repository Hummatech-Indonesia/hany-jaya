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
        if(!Schema::hasColumn('buyers', 'limit_debt')){
            Schema::table('buyers', function (Blueprint $table) {
                $table->integer('limit_debt')->default(10000000);
            });
        }
        if(!Schema::hasColumn('buyers', 'limit_date_debt')){
            Schema::table('buyers', function (Blueprint $table) {
                $table->datetime('limit_date_debt')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer_debt', function (Blueprint $table) {
            //
        });
    }
};
