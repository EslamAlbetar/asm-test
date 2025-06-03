<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('position_names', function (Blueprint $table) {
            $table->unsignedBigInteger('total_items_id')->nullable(); // أو شيل nullable لو لازم تكون موجودة دايمًا
        });
    }

    public function down()
    {
        Schema::table('position_names', function (Blueprint $table) {
            $table->dropColumn('total_items_id');
        });
    }
};
