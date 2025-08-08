<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\Chapter;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $book = Book::first();
        if ($book) {
            Chapter::create([
                'title' => 'Chapter 1: Introduction',
                'book_id' => $book->id,
                'content' => 'This is the first chapter.',
                'status' => 'published',
            ]);
        }
    }
}
