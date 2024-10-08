<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PharmacySeeder::class,
            AboutSeeder::class,
            PrivacySeeder::class,
            FaqSeeder::class,
            TermSeeder::class,
            OfferSeeder::class,
            SideSeeder::class,
            IndicationSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
