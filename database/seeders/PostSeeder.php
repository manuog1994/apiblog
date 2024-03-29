<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(50)->create()->each(function(Post $post){
            Image::factory(4)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class,
            ]);

            $post->tags()->attach([
                rand(1, 4),
                rand(5, 8)]
            );
        });
    }
}
