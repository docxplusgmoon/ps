<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            [
                'country_id' => 1,
                'name'       => 'New York'
            ],
            [
                'country_id' => 2,
                'name'       => 'Almaty'
            ],
            [
                'country_id' => 3,
                'name'       => 'Moscow'
            ],
        ]);
    }
}
