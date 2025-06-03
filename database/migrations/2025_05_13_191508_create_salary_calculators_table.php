<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salary_calculators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->decimal('base_salary', 10, 2)->default(0); // الراتب الشهري
            $table->decimal('hourly_shift', 8)->default(0); // مدة الشيفت الواحد
            $table->decimal('gools_day', 4)->default(0); // عدد الايام المستحقة 
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_calculators');
    }
};
