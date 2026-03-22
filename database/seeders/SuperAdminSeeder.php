<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => env('SUPER_ADMIN_EMAIL', 'superadmin@example.com')],
            [
                'name' => 'Super Admin',
                'username' => env('SUPER_ADMIN_USERNAME',),
                'phone_number' => env('SUPER_ADMIN_PHONE',),
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD',)),
                'super_admin' => true,
                'status' => 'active',
            ]
        );
    }
}