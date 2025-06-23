<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //  ده كول للكلاس الuserseeder اسمه علشان ينفز الاتنين فانكشن ال كتبناهم

        Store::factory(5)->create();
        Category::factory(10)->create();
        Product::factory(100)->create();
        //$this->call(UserSeeder::class);

      //  php artisan db:seed
        // دي زي 
        // php artisan migration
        // بس ده بينفز البيانات ال دخلتها من خلال سيييدر

    }
}
