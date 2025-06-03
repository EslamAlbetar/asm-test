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
        Schema::create('parteners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        
            $table->foreignId('user_id')->constrained('users'); // الشريك
            $table->string('name_partener')->nullable();
            $table->string('age')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('job')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('percentage', 5, 2);
            $table->decimal('total_profits_you', 15, 2);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parteners');
    }
};
