<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\User;
use App\Chapter;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $chapter = Chapter::first();

        // Seed 5 komentar untuk chapter pertama
        for ($i = 1; $i <= 5; $i++) {
            Comment::create([
                'user_id' => $user ? $user->id : 1,
                'chapter_id' => $chapter ? $chapter->id : 1,
                'content' => "Ini komentar ke-$i untuk chapter.",
            ]);
        }
    }
}
