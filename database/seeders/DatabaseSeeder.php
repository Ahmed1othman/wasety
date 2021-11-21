<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
       $this->call(InfoSeeder::class);
    }
}
