<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = config('pharmacy.seeder.chunkSize');
        $totalRecords = config('pharmacy.seeder.chunkSize');
        $data = [];
        for ($i = 0; $i < $totalRecords; $i++) {
            $data[] = [
                'question' => [
                    'en' => fake()->realText(),
                    'ar' => fake('ar_JO')->realText()
                ],
                'answer' => [
                    'en' => fake()->realText(),
                    'ar' => fake('ar_JO')->realText()
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    FAQ::create($item);
                }
                $data = [];
            }
        }
        if (!empty($data)) {
            foreach ($data as $item) {
                FAQ::create($item);
            }
        }
    }
}
