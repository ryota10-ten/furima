<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;



class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'method' => $this->faker->word(),
            'post' => $this->faker->word(),
            'address' => $this->faker->word(),
            'User_id' => User::factory(),
            'Product_id' => Product::factory(),
        ];
    }
}