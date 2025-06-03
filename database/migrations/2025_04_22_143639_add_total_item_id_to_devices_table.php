<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->unsignedBigInteger('total_items_id')->nullable()->after('device_image');
        });
    }
    
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('total_items_id');
        });
    }
};
