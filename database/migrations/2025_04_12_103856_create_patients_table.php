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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('dr_name')->nullable();
            $table->longText('category')->nullable();
            $table->longText('positions')->nullable();
            $table->longText('situations')->nullable();
            $table->string('complaint')->nullable();
            $table->string('location')->nullable();
            $table->string('discount')->nullable();
            $table->string('price')->nullable();
            $table->string('finalPrice')->nullable();
            $table->string('payment')->nullable();
            $table->longText('comments')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('not complete');
            $table->string('report')->default('not complete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
