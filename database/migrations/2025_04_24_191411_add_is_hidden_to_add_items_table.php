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
        Schema::table('add_items', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false); // false = ظاهر، true = مخفي
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('add_items', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
};
