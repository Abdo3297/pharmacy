<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = config('pharmacy.seeder.chunkSize');
        $totalRecords = config('pharmacy.seeder.totalRecords');
        $data = [];
        for ($i = 0; $i < $totalRecords; $i++) {
            $data[] = [
                'user_id' => rand(1, User::count()),
                'total_amount' => fake()->randomNumber(),
                'payment_id' => fake()->randomNumber(8, true),
                'payment_status' => [true, false][rand(0, 1)],
                'payment_type' => 'stripe',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                Order::insert($data);
                $orders = Order::whereIn('id', Order::latest('id')->take($chunkSize)->pluck('id'))->get();
                foreach ($orders as $order) {
                    $this->addOrderItems($order);
                }
                $data = [];
            }
        }
        if (! empty($data)) {
            Order::insert($data);
            $orders = Order::whereIn('id', Order::latest('id')->take(count($data))->pluck('id'))->get();
            foreach ($orders as $order) {
                $this->addOrderItems($order);
            }
        }
    }

    protected function addOrderItems(Order $order): void
    {
        $numberOfItems = rand(1, 5);

        for ($i = 0; $i < $numberOfItems; $i++) {
            $product = Product::inRandomOrder()->first(); // Get a random product

            // Check if the product is already associated with the order
            if ($order->products()->where('product_id', $product->id)->exists()) {
                continue; // Skip adding this product if it's already associated
            }

            $quantity = fake()->randomNumber(2, true);
            $unitPrice = $product->unit_price;
            $totalPrice = $quantity * $unitPrice;

            // Associate the product with the order
            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
