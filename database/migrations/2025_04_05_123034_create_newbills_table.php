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
        Schema::create('newbills', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable();
            $table->string('bill_name')->nullable();
            $table->string('bill_type')->nullable();
            $table->string('required_qty')->nullable();
            $table->string('price_bill')->nullable();
            $table->string('comments_bill')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newbills');
    }
};
