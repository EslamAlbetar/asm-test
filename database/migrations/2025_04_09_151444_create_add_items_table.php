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
        Schema::create('add_items', function (Blueprint $table) {
            $table->id();
            
            $table->string('total_items_id')->nullable();

            $table->string('category')->nullable();

            $table->string('item_name')->nullable();

            $table->string('quantity')->nullable();
            
            $table->string('total_price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_items');
    }
};
