<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = config('pharmacy.seeder.chunkSize');
        $totalRecords = config('pharmacy.seeder.totalRecords');
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data = [];
        for ($i = 0; $i < $totalRecords; $i++) {
            $data[] = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'password' => bcrypt('password'),
                'gender' => ['male', 'female'][rand(0, 1)],
                'is_admin' => false,
                'birth' => Carbon::createFromFormat('d-m-Y', fake()->date('d-m-Y'))->format('Y-m-d'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                User::insert($data);
                $users = User::take($chunkSize)->get();
                foreach ($users as $user) {
                    $user->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('userProfile');
                    $this->addFavourites($user);
                }
                $data = [];
            }
        }
        if (!empty($data)) {
            User::insert($data);
            $users = User::take($chunkSize)->get();
            foreach ($users as $user) {
                $user->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('userProfile');
                $this->addFavourites($user);
            }
        }
    }
    protected function addFavourites(User $user): void
    {
        $favourites = Product::inRandomOrder()->take(rand(1, 5))->pluck('id');
        $user->favourites()->sync($favourites);
    }
}
