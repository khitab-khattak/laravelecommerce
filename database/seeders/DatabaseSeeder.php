<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(10)->create();
        $brands = Brand::factory(10)->create();
    
        $categoryIds = $categories->pluck('id')->toArray();
        $brandIds = $brands->pluck('id')->toArray();
    
        Product::factory(50)->state(function () use ($categoryIds, $brandIds) {
            return [
                'category_id' => Arr::random($categoryIds),
                'brand_id'    => Arr::random($brandIds),
            ];
        })->create();
    }
}
