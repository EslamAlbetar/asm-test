<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('usertypes', function (Blueprint $table) {
            $table->id();
            $table->string('name_usertype');
            $table->string('color_code', 7);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('usertypes');
    }
};
