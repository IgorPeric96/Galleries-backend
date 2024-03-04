<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(10)->create()->each(function ($user) {
            $galleries = Gallery::factory(rand(1, 4))->create(['user_id' => $user->id]);
            $galleries->each(function ($gallery) {
                Image::factory(rand(5, 10))->create(['gallery_id' => $gallery->id]);
                Comment::factory(rand(1, 5))->create([
                    'gallery_id' => $gallery->id,
                    'user_id' => $gallery->user_id 
                ]);
            });
        });
    }
}
