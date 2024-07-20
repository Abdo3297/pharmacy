<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalRecords = 1;
        for ($i = 0; $i < $totalRecords; $i++) {
            $data = [
                'name' => [
                    'en' => fake()->name(),
                    'ar' => fake('ar_JO')->name()
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $result = Pharmacy::create($data);
            $result->addMediaFromUrl(url('assets/images/logo.png'))->toMediaCollection('pharmacyLogo');
            $result->addMediaFromUrl(url('assets/images/logo.png'))->toMediaCollection('pharmacyCarousel');
            $result->addMediaFromUrl(url('assets/images/logo.png'))->toMediaCollection('pharmacyCarousel');
            $result->addMediaFromUrl(url('assets/images/logo.png'))->toMediaCollection('pharmacyCarousel');
        }
    }
}
