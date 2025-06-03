<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AllPatient;
use App\Models\Donations;
use App\Models\SalaryCalculator;
use App\Models\AddItem;
use App\Models\FinancialAccounting;


class UpdateFinancialAccounting extends Command
{
    protected $signature = 'financial:update';
    protected $description = 'Update financial accounting row with latest totals';

    public function handle()
    {
        $inputs = AllPatient::sum('price') + Donations::sum('amount');
        $outputs = AddItem::sum('total_price');
        $gross = $inputs - $outputs;

        FinancialAccounting::updateOrCreate(
            ['id' => 1],
            [
                'inputs' => $inputs,
                'outputs' => $outputs,
                'gross_profit' => $gross,
            ]
        );

        $this->info('تم تحديث الحسابات المالية بنجاح.');
    }
}
