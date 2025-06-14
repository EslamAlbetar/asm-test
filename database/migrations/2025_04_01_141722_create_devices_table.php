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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_serial')->nullable();
            $table->string('device_get_status')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('price_device')->nullable();
            $table->string('device_image')->nullable();
            $table->unsignedBigInteger('total_item_id')->nullable(); // << هنا الجديد

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
