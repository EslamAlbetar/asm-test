<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AuthedPage;
use Illuminate\Database\Seeder;

class AuthedPagesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $exists = AuthedPage::where('user_id', $user->id)->first();

            if (!$exists) {
                $data = [];

                // لو سوبر أدمن: كل الصلاحيات true
                if ($user->usertype !== 'user') {
                    $data = [
                        'user_id' => $user->id,
                        'admin_dashboard' => false,
                        'add_patient_admin' => false,
                        'view_category' => false,
                        'waiting_list_admin' => false,
                        'total_patients_admin' => false,
                        'writing_report' => false,
                        'center_devices' => false,
                        'donations_admin' => false,
                        'staff_team' => false,
                        'bills_admin' => false,
                        'all_bills' => false,
                        'total_items_admin' => false,
                        'profit' => false,
                        'profile_user' => true,
                        'details_staff' => false,
                        'update_patient_list_admin' => false,
                        'update_waiting_list_admin' => false,
                        'completePatient' => false,
                        'delete_staff' => false,
                        'update_staff' => false,
                        'write_report_now' => false,
                        'add_user_type' => false,
                        'update_device' => false,
                        'shift_start' => false,
                        'shift_admin' => false,
                        'vacation' => false,
                        'vacation_admin' => false,
                        'deduction' => false,
                        'deduction_admin' => false,
                        'permission' => false,
                        'permission_admin' => false,
                        'continue_bill' => false,
                        'add_bill' => false,
                        'add_item' => false,
                        'add_device' => false,
                        'parteners' => false,
                        'parteners_admin' => false,
                        'add_partener' => false,
                        'financial_accounting' => false,
                        'editName_center' => false,
                    ];
                }

                AuthedPage::create($data);
            }
        }
    }
}
