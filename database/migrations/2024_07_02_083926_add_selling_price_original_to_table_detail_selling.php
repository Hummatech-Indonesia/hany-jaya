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
        if(!Schema::hasColumn('detail_sellings','selling_price_original')){
            Schema::table('detail_sellings', function (Blueprint $table) {
                $table->integer('selling_price_original')->default(0);
            });
        }   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('detail_sellings','selling_price_original')){
            Schema::table('detail_sellings', function (Blueprint $table) {
                $table->dropColumn('selling_price_original');
            });
        }
    }
};
