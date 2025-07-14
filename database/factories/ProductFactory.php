<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
public function definition(): array
{
    $name = $this->faker->words(5, true);
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $this->faker->sentence(15),
        'image' => 'https://placehold.co/600x600/001166/ffffff.png?text=' . urlencode($name),
        'price' => $this->faker->randomFloat(1, 1, max: 499),
        'compare_price' => $this->faker->randomFloat(1, 500, max: 999),
        'featured' => rand(0, 1),
        'category_id' => Category::inRandomOrder()->first()->id,
        'store_id' => Store::inRandomOrder()->first()->id,
    ];
}

}
