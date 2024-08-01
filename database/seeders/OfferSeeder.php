<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
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
                'name' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->name(),
                ],
                'discount_type' => 'percentage',
                'discount_value' => fake()->randomDigit(),
                'start_date' => now(),
                'end_date' => now()->addDays(4),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    Offer::create($item);
                }
                $data = [];
            }
        }
        if (! empty($data)) {
            foreach ($data as $item) {
                Offer::create($item);
            }
        }
    }
}
