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
        if(!Schema::hasColumn('product_units','is_delete')){
            Schema::table('product_units', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('product_units','deleted_at')){
            Schema::table('product_units', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
            });
        }
        if(!Schema::hasColumn('supplier_products','is_delete')){
            Schema::table('supplier_products', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('supplier_products','deleted_at')){
            Schema::table('supplier_products', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
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
