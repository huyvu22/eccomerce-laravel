<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'username' => 'administrator',
                'email'=>'admin@gmail.com',
                'role'=>'admin',
                'status' => 'active',
                'password'=>Hash::make('12345678'),
            ],

           [
               'name' => 'Vendor user',
               'username' => 'vendor',
               'email'=>'vendor@gmail.com',
               'role'=>'vendor',
               'status' => 'active',
               'password'=>Hash::make('12345678'),
           ],

           [
               'name' => 'User',
               'username' => 'user',
               'email'=>'user@gmail.com',
               'role'=>'user',
               'status' => 'active',
               'password'=>Hash::make('12345678'),
           ],
       ]);
    }
}
