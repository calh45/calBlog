<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Post model and create Activity model for each Post model
        factory(App\Post::class, 20)->create()->each(function ($post) {
            $post->activity()->save(factory(\App\Activity::class)->
            create(["activity_type" => "Post", "content" => $post->content, "user_id" => $post->user_id, "post_id" => $post->id]));
        });
    }
}
