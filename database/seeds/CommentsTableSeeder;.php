<?php

use App\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Comment::class, 20)->create()->each(function ($comment) {
            $comment->activity()->save(factory(\App\Activity::class)->create(["activity_type" => "Comment", "content" => $comment->content, "user_id" => $comment->user_id, "post_id" => $comment->id]));
        });;
    }
}
