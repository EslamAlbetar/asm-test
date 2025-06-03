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
        Schema::create('info_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name_center')->nullable();
            $table->string('last_name')->nullable();
            $table->string('target_pat')->nullable();
            $table->string('target_prof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_centers');
    }
};
