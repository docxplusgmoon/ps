<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_rates')->insert([
            [
                'currency_id' => 2,
                'actual_date' => date('Y-m-d'),
                'exchange_rate' => '429.49',
            ],
            [
                'currency_id' => 3,
                'actual_date' => date('Y-m-d'),
                'exchange_rate' => '75.65',
            ],
        ]);
    }
}
