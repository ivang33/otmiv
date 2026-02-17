<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Shirts']);
        Category::create(['name' => 'Pants']);
        Category::create(['name' => 'Dresses']);
        Category::create(['name' => 'Jackets']);
        Category::create(['name' => 'Bedding']);
        Category::create(['name' => 'Towels']);
    }
}
