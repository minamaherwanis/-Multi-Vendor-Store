<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eloquent Model الطريقة الأولى: باستخدام

        User::create([
            'name' => 'mina maher',
            'email' => 'mina@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '01224502280',


        ]);

        // مباشرةQuery Builderلطريقة الثانية: باستخدام
        // تُستخدم هذه الطريقة لكتابة الاستعلامات بشكل مباشر وأسرع
        DB::table('users')->insert([
            'name' => 'pop',
            'email' => 'pop@gmail.com',
            'password' => Hash::make('password12fugh'),
            'phone_number' => '01224554680',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}