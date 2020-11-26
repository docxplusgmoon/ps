<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'code' => 'USD',
                'name' => 'USA dollars',
            ],
            [
                'code' => 'KZT',
                'name' => 'Kazakhstan tenge',
            ],
            [
                'code' => 'RUB',
                'name' => 'Russian ruble',
            ],
        ]);
    }
}
