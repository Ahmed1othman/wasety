<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();


        $users = new User();
        $users->first_name = "Mustafa";
        $users->last_name = "Ali";
        $users->phone = "0123456789";
        $users->email = "admin@admin.com";
        $users->country_id = 1;
        $users->active = 1;
        $users->city_id = 1;
        $users->type = "admin";
        $users->password = Hash::make('12345678');
        $users->save();


       $users = new User();
       $users->first_name = "test";
       $users->last_name = "test";
       $users->phone = "0123123123";
       $users->email = "test@test.com";
       $users->country_id = 1;
       $users->city_id = 1;
       $users->type = "customer";
       $users->password = Hash::make('12345678');
       $users->save();


       $users = new User();
       $users->first_name = "dealer";
       $users->last_name = "dealer";
       $users->phone = "0123456123";
       $users->email = "dealer@dealer.com";
       $users->country_id = 1;
       $users->city_id = 1;
       $users->type = "dealer";
       $users->password = Hash::make('12345678');
       $users->save();
    }
}
