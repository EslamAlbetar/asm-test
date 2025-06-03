<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('center_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->default('test');
            $table->string('second_name')->default('center');
            $table->string('target_pat_td')->default('15');
            $table->string('target_pat_mon')->default('50');
            $table->string('address')->default('test');
            $table->string('phone')->default('0123456789');
            $table->timestamps();
        });

        // إضافة البيانات الافتراضية
        DB::table('center_details')->insert([
            'first_name' => 'Test',
            'second_name' => 'Center',
            'target_pat_td' => '15',
            'target_pat_mon' => '50',
            'address' => 'test',
            'phone' => '0123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_details');
    }
};
