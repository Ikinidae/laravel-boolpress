<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class PostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $categories_ids = Category::all()->pluck('id');
        $users_ids = User::all()->pluck('id');

        for ($i = 0; $i < 200; $i++) {
            $post = new Post;
            $post->user_id = $faker->randomElement($users_ids);
            $post->title = $faker->words(rand(3,10), true);
            $post->category_id = $faker->randomElement($categories_ids);
            $post->slug = Post::getSlug($post->title);

            // $post->image = 'https://picsum.photos/id/' . rand(1,100) . '/500/300';
            $number = rand(0, 14);
            if ($number) {
                $contents = new File('/Users/Ikaa/Desktop/Esercizi/PHP/laravel-boolpress/storage/app/public/lorempicsum/005(' . $number . ').jpg');
                $post->image = Storage::put('uploads', $contents);
            } else {
                $post->image = null;
            }

            $post->content = $faker->paragraph(rand(2,10), true);
            $post->excerpt = $faker->paragraph();
            $post->save();
        }
    }
}
