<?php

namespace Database\Seeders;

use App\Models\Usertype;
use Illuminate\Database\Seeder;

class UsertypeSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء البيانات فقط إذا كان الجدول فارغاً
        if (Usertype::count() == 0) {
            $usertypes = [
                [
                    'id' => 1,
                    'name_usertype' => 'user',
                    'color_code' => '#474747'
                ]
              
            ];

            foreach ($usertypes as $usertype) {
                Usertype::create($usertype);
            }
        }
    }
}