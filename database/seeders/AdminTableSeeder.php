<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
         $adminRecords = [
                [
                    'name'=>'Admin',
                    'type'=>'superadmin',
                    'mobile'=>"01839317938",
                    'email'=>'admin@gmail.com',
                    'password'=>Hash::make('4444'),
                    'image'=>'',
                    'status'=>1,
                ],
        ];
        Admin::insert($adminRecords);
    }
}
