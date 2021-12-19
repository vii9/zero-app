<?php

namespace Database\Seeders;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::truncate();
        $now = Carbon::now()->toDateTimeString();
        $comments =  [
            [
                'user_id' => 2,
                'post_id' => 3,
                'body_content' => 'from userId 2 haha and postId3',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 4,
                'post_id' => 5,
                'body_content' => 'from userId 4 and postId5',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 8,
                'body_content' => 'from userId 2 and postId8',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 4,
                'body_content' => 'from userId2 JJJ 2 and postId4',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 3,
                'body_content' => 'from userId 2 and postId3',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 5,
                'post_id' => 3,
                'body_content' => 'from userId 5 XXXX and postId3',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 5,
                'post_id' => 8,
                'body_content' => 'from userId 5 and postId8',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 4,
                'body_content' => 'from userId 2 and postId4',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 5,
                'body_content' => 'from userId 2 and postId5 QW',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 1,
                'post_id' => 3,
                'body_content' => 'from userId 1 and postId3',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 3,
                'post_id' => 4,
                'body_content' => 'from userId 3 and postId4',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 2,
                'post_id' => 5,
                'body_content' => 'from userId 2 and postId5',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 5,
                'post_id' => 3,
                'body_content' => 'from userId 5 and postId3',
                'created_at'=> $now,
                'updated_at'=> $now
            ]
        ];

        Comment::insert($comments);
    }
}
