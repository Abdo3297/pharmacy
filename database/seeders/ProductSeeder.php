<?php

namespace Database\Seeders;

use App\Models\Side;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Indication;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
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
                'unit_price' => fake()->randomFloat(2),
                'no_units' => fake()->randomDigitNotNull(),
                'barcode' => fake()->isbn10(),
                'stock' => fake()->randomDigitNotNull(),
                'alert' => fake()->randomDigitNotNull(),
                'name' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->name()
                ],
                'description' => [
                    'en' => fake()->realText(),
                    'ar' => fake('ar_JO')->realText()
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($data) === $chunkSize) {
                $this->createProducts($data, $chunkSize);
                $data = [];
            }
        }

        if (!empty($data)) {
            $this->createProducts($data, $chunkSize);
        }
    }

    /**
     * Create products and attach categories.
     */
    protected function createProducts(array $data, int $chunkSize): void
    {
        foreach ($data as $item) {
            $product = Product::create($item);
            $product->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('productImages');
            // Attach random categories
            $categories = Category::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $product->categories()->sync($categories);
            // Attach random side effects
            $sideEffects = Side::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $product->sideEffects()->sync($sideEffects);
            // Attach random indications
            $indications = Indication::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $product->indications()->sync($indications);
            // Attach random offers
            $indications = Offer::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $product->offers()->sync($indications);
        }
    }
}
