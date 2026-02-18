<?php

namespace Database\Factories;

use App\Models\LaundryItem;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaundryItemFactory extends Factory
{
    protected $model = LaundryItem::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'user_id' => User::factory(),
        ];
    }
}
