<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Condition;
use Database\Factories\ConditionFactory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 10000),
            'detail' => $this->faker->sentence(),
            'brand' => $this->faker->company(),
            'condition_id' => Condition::factory(),
            'img' => $this->faker->imageUrl(),
        ];
    }
}
