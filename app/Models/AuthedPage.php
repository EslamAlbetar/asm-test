<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthedPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_dashboard',
        'add_patient_admin',
        'view_category',
        'waiting_list_admin',
        'total_patients_admin',
        'writing_report',
        'center_devices',
        'donations_admin',
        'staff_team',
        'bills_admin',
        'all_bills',
        'total_items_admin',
        'profit',
        'profile_user',
        'details_staff',
        'update_patient_list_admin',
        'update_waiting_list_admin',
        'completePatient',
        'delete_staff',
        'update_staff',
        'write_report_now',
        'add_user_type',
        'update_device',
        'shift_start',
        'shift_admin',
        'vacation',
        'vacation_admin',
        'deduction',
        'deduction_admin',
        'permission',
        'permission_admin',
        'continue_bill',
        'add_bill',
        'add_item',
        'add_device',
        'parteners',
        'parteners_admin',
        'add_partener',
        'financial_accounting',
        'editName_center',

    ];
}