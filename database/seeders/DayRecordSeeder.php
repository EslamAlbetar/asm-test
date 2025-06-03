<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\DayRecord;
use Carbon\Carbon;

class DayRecordSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $year = 2025;
        $month = 4;
        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;

        foreach ($categories as $category) {
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($year, $month, $day);
                $inputs = rand(500, 2000);
                $payments = rand(300, 1500);

                DayRecord::create([
                    'category_id' => $category->id,
                    'date' => $date->format('Y-m-d'),
                    'day_name' => $date->locale('ar')->dayName,
                    'inputs' => $inputs,
                    'payments' => $payments,
                ]);
            }
        }
    }
}
