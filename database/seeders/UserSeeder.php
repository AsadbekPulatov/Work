<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'super_admin',
            'user_id' => 1,
            'status' => 1
        ]);
//        DB::table('users')->insert([
//            'name'=>'admin',
//            'email'=>'admin@gmail.com',
//            'password'=>Hash::make('admin'),
//        ]);
    }
}
