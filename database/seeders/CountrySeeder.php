<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();
        Country::create(['name' => 'Egypt']);
        Country::create(['name' => 'UEA']);

        DB::table('cities')->delete();
        City::create(['name' => 'Cairo','country_id'=>1]);
        City::create(['name' => 'Alexandria','country_id'=>1]);
    }
}
