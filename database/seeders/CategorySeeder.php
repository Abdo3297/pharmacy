<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                    Category::create($item);
                    $categories = Category::take($chunkSize)->get();
                    foreach ($categories as $category) {
                        $category->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('categoryImages');
                    }
                }
                $data = [];
            }
        }
        if (! empty($data)) {
            foreach ($data as $item) {
                Category::create($item);
                $categories = Category::take($chunkSize)->get();
                foreach ($categories as $category) {
                    $category->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('categoryImages');
                }
            }
        }
    }
}
