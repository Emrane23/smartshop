<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryNames = [
            'Electronics',
            'Fashion',
            'Home & Garden',
            'Sports & Outdoors',
            'Toys & Games',
            'Automotive',
            'Beauty & Personal Care',
            'Books',
            'Music',
            'Groceries',
            'Health & Wellness',
            'Jewelry',
            'Office Supplies',
            'Pet Supplies',
            'Tools & Hardware',
            'Smartphones',
            'Gaming',
            'Watches',
            'Furniture',
            'Baby Products',
            'Cameras',
            'Drones',
            'Laptops',
            'Shoes',
            'Bags & Luggage',
            'Fitness Equipment',
            'Kitchen Appliances',
            'Camping & Hiking',
            'Musical Instruments',
            'Art & Crafts',
            'Industrial Supplies'
        ];

        foreach ($categoryNames as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Description for ' . $name
            ]);
        }
    }
}
