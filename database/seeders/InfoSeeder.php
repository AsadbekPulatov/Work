<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_infos')->insert([

            'name' => 'Super',
            'surname'=>'Admin',
            'father_name'=>'Mega',
            'address'=>'Urganch',
            'passport'=>'AA0000000',
            'phone'=>'+999001112233',
            'birthdate'=>Carbon::now(),
        ]);
    }
}
