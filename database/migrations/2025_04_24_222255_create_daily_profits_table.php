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
        Schema::create('daily_profits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // ربط بالفئة
            $table->decimal('total_inputs', 15, 2)->default(0);
            $table->decimal('total_payments', 15, 2)->default(0);
            $table->date('date'); // تاريخ اليوم
            $table->string('day_name'); // اسم اليوم
            $table->year('year'); // السنة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_profits');
    }
};
