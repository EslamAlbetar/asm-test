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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('required_quantity')->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('expiration_date')->nullable();
            $table->string('image')->nullable();
            $table->string('comments_bill')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
