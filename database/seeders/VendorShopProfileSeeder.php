<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email','vendor@gmail.com')->first();
        $vendor = new Vendor();
        $vendor->banner = 'uploads/1213.jpg';
        $vendor->shop_name = 'Vendor Shop';
        $vendor->phone = '123456789';
        $vendor->email = 'vendor@gmail.com';
        $vendor->address = 'No 32, Ho Chi Minh city';
        $vendor->description = 'description shop';
        $vendor->user_id = $user->id;
        $vendor->status = 1;
        $vendor->save();
    }
}
