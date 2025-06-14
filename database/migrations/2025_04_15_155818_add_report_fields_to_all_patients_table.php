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
    Schema::table('all_patients', function (Blueprint $table) {
        $table->longText('report_details')->nullable();
        $table->string('doctor_signature')->nullable();
        $table->string('report_pdf_path')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_patients', function (Blueprint $table) {
            //
        });
    }
};
