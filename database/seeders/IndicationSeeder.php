<?php

namespace Database\Seeders;

use App\Models\Indication;
use Illuminate\Database\Seeder;

class IndicationSeeder extends Seeder
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    Indication::create($item);
                }
                $data = [];
            }
        }
        if (! empty($data)) {
            foreach ($data as $item) {
                Indication::create($item);
            }
        }
    }
}
