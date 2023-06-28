<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $ppn = $this->faker->numberBetween(1, 5);
        $ppp = $this->faker->numberBetween(1, 10);
        $paragraphs = $this->faker->paragraphs(rand(2, 6));
        $text = "";
        foreach ($paragraphs as $pr) {
            $text .= "<p>{$pr}</p>";
        }
        
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->numberBetween(0, 10) . '.jpg',
            'text' => $text,
            'code' => $this->faker->numberBetween(1000000000, 1000000000000),
            'stock' => $this->faker->randomNumber(3, false),
            'buying_price' => $this->faker->randomNumber(3, false),
            'wholesale_price' => random_int(10, 20),
            'retail_price' => random_int(30, 40),
            'promo_price' => $ppn == 1 ? random_int(20, 30) : NULL,
            'weight' => random_int(1, 100),
            'brand' => $this->faker->word(),
            'property' => $ppp == 1 ? 'Хит' : NULL,
            'position' => random_int(0, 10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
