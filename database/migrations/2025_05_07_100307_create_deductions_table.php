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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('amount_ded');
            $table->longText('reason_ded');
            $table->string('status_ded');
            $table->string('signature_ded')->nullable();
            $table->string('objection_ded')->nullable();
            $table->string('objection_reason')->nullable();
            $table->string('objection_status')->nullable();
            $table->longText('reason_admin_objection')->nullable();
            $table->string('signature_objection_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
