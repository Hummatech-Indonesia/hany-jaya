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
        if(!Schema::hasColumn('users','is_delete')){
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('suppliers','is_delete')){
            Schema::table('suppliers', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('products','is_delete')){
            Schema::table('products', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('categories','is_delete')){
            Schema::table('categories', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }
        if(!Schema::hasColumn('units','is_delete')){
            Schema::table('units', function (Blueprint $table) {
                $table->tinyInteger('is_delete')->default(0);
            });
        }

        if(!Schema::hasColumn('users','deleted_at')){
            Schema::table('users', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
            });
        }
        if(!Schema::hasColumn('suppliers','deleted_at')){
            Schema::table('suppliers', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
            });
        }
        if(!Schema::hasColumn('products','deleted_at')){
            Schema::table('products', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
            });
        }
        if(!Schema::hasColumn('categories','deleted_at')){
            Schema::table('categories', function (Blueprint $table) {
                $table->datetime('deleted_at')->nullable();
            });
        }
        if(!Schema::hasColumn('units','deleted_at')){
            Schema::table('units', function (Blueprint $table) {
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
