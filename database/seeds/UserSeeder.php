<?php

use App\Category;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create()->each(function ($user) {
            $user->posts()
            ->saveMany(factory(Post::class, 3)->make())
            ->each(function ($post) {
                $post->categories()
                    ->attach(Category::all()->random());
            });
        });
    }
}
