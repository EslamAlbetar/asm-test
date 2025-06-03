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
        Schema::create('day_records', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // مثال: 2025-04-25
            $table->string('day_name'); // مثال: الجمعة
            $table->decimal('inputs', 10, 2)->default(0);
            $table->decimal('payments', 10, 2)->default(0);
            $table->timestamps(); // يحتوي على created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_records');
    }
};
