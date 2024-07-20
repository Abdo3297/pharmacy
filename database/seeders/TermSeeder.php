<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
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
                'key' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->realText()
                ],
                'value' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->realText()
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    Term::create($item);
                }
                $data = [];
            }
        }
        if (!empty($data)) {
            foreach ($data as $item) {
                Term::create($item);
            }
        }
    }
}
