<?php

use App\Enums\StatusEnum;
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
        if(Schema::hasColumn('sellings','status_payment')){
            Schema::table('sellings', function (Blueprint $table) {
                $table->enum('status_payment',[StatusEnum::DEBT->value, StatusEnum::CASH->value, StatusEnum::SPLIT->value])->change();
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
