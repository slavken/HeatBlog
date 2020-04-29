<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class CommentParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $comment = Comment::where('parent_id', null)->get()->random();

            factory(Comment::class)->create([
                'post_id' => $comment->post_id,
                'parent_id' => $comment->id
            ]);
        }
    }
}
