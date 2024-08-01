<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
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
                'sender_id' => rand(1, User::count()),
                'receiver_id' => rand(1, User::count()),
                'message' => fake()->realText(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($data) === $chunkSize) {
                foreach ($data as $item) {
                    Chat::create($item);
                    $chats = Chat::take($chunkSize)->get();
                    foreach ($chats as $chat) {
                        $chat->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('chat');
                    }
                }
                $data = [];
            }
        }
        if (! empty($data)) {
            foreach ($data as $item) {
                Chat::create($item);
                $chats = Chat::take($chunkSize)->get();
                foreach ($chats as $chat) {
                    $chat->addMediaFromUrl('https://avatars.githubusercontent.com/u/97165289')->toMediaCollection('chat');
                }
            }
        }
    }
}
