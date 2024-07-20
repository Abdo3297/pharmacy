<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = 1;
        $totalRecords = 1;
        $data = [];
        for ($i = 0; $i < $totalRecords; $i++) {
            $data[] = [
                'content' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->name()
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    About::create($item);
                }
                $data = [];
            }
        }
        if (!empty($data)) {
            foreach ($data as $item) {
                About::create($item);
            }
        }
    }
}
