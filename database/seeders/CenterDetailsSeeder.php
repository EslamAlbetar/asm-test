<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CenterDetails;

class CenterDetailsSeeder extends Seeder
{
    public function run()
    {
        // هتتحقق أولًا لو فيه بيانات موجودة قبل ما تضيف
        if (CenterDetails::count() == 0) {
            CenterDetails::create([
                'first_name' => 'Test',
                'second_name' => 'Center',
                'target_pat_td' => '15',
                'target_pat_mon' => '50',
                'address' => 'test',
                'phone' => '0123456789',
            ]);
        }
    }
}