<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        $now = Carbon::now()->toDateTimeString();

        $posts =  [
            [
                'user_id' => 3,
                'title' => 'from User Editor',
                'content' => '$2y$o9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 5,
                'title' => 'from SamHoAuthor2',
                'content' => '$2y$10$92IXG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 3,
                'title' => 'from User Editor',
                'content' => '121 dssss hjjhhjll',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 4,
                'title' => 'from ClientAuthor',
                'content' => 'AAA C/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 5,
                'title' => 'from SamHoAuthor2',
                'content' => '$2y$10$92',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 3,
                'title' => 'from User Editor',
                'content' => '$2og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 4,
                'title' => 'from ClientAuthor',
                'content' => 'AAS 13 FFF34 fgd ddfd',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'user_id' => 3,
                'title' => 'from User Editor',
                'content' => '$2y$10$92IeWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ]
        ];

        Post::insert($posts);
    }
}
