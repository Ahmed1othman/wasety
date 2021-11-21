<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->delete();
        Payment::create(['option' => 'paypal_username','value' => '','type' => 'string']);
        Payment::create(['option' => 'paypal_password','value' => '','type' => 'string']);
        Payment::create(['option' => 'paypal_api_secret','value' => '','type' => 'string']);
        Payment::create(['option' => 'strip_username','value' => '','type' => 'string']);
        Payment::create(['option' => 'strip_password','value' => '','type' => 'string']);
        Payment::create(['option' => 'strip_api_secret','value' => '','type' => 'string']);
    }
}
