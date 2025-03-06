<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $products = Product::factory(20)->create();

        Customer::factory(10)->create()->each(function ($customer) use ($products) {
            Order::factory(rand(1, 3))->create(['customer_id' => $customer->id])->each(function ($order) use ($products) {
                $total = 0;

                $selectedProducts = $products->random(rand(1, 5));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 5);
                    $price = $product->price * $quantity;

                    $order->products()->attach($product->id, [
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $total += $price;
                }

                $order->update(['total' => $total]);
            });
        });
    }
}
