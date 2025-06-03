<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthedPagesTable extends Migration
{
    public function up()
    {
        Schema::create('authed_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('staff_team')->default(false);
            $table->boolean('update_staff')->default(false);
            $table->boolean('admin_dashboard')->default(false);
            $table->boolean('add_patient_admin')->default(false);
            $table->boolean('view_category')->default(false);
            $table->boolean('waiting_list_admin')->default(false);
            $table->boolean('total_patients_admin')->default(false);
            $table->boolean('writing_report')->default(false);
            $table->boolean('center_devices')->default(false);
            $table->boolean('donations_admin')->default(false);
            $table->boolean('bills_admin')->default(false);
            $table->boolean('all_bills')->default(false);
            $table->boolean('total_items_admin')->default(false);
            $table->boolean('profit')->default(false);
            $table->boolean('profile_user')->default(true); // الوحيدة اللي true بشكل افتراضي
            $table->boolean('details_staff')->default(false);
            $table->boolean('update_patient_list_admin')->default(false);
            $table->boolean('update_waiting_list_admin')->default(false);
            $table->boolean('completePatient')->default(false);
            $table->boolean('delete_staff')->default(false);
            $table->boolean('write_report_now')->default(false);
            $table->boolean('add_user_type')->default(false);
            $table->boolean('update_device')->default(false);
            $table->boolean('shift_start')->default(false);
            $table->boolean('shift_admin')->default(false);
            $table->boolean('vacation')->default(false);
            $table->boolean('vacation_admin')->default(false);
            $table->boolean('deduction')->default(false);
            $table->boolean('deduction_admin')->default(false);
            $table->boolean('permission')->default(false);
            $table->boolean('permission_admin')->default(false);
            $table->boolean('continue_bill')->default(false);
            $table->boolean('add_bill')->default(false);
            $table->boolean('add_item')->default(false);
            $table->boolean('add_device')->default(false);


            $table->boolean('parteners')->default(false);
            $table->boolean('parteners_admin')->default(false);
            $table->boolean('add_partener')->default(false);
            $table->boolean('financial_accounting')->default(false);
            $table->boolean('editName_center')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('authed_pages');
    }
}
