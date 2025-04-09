<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class AssignCategoriesToProductsSeeder extends Seeder
{
    /**
     * Exécute le seeder
     */
    public function run()
    {

        $products = Product::all();
        $categories = Category::all();

        $this->command->info('Start assigning categories to products...');
        $this->command->getOutput()->progressStart($products->count());

        foreach ($products as $product) {
            $randomCategories = $categories->random(rand(1, 3))->pluck('id');
            $product->categories()->sync($randomCategories);
            
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('Category assignment complete!');
    }
}