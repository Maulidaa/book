<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author = User::where('role_id', 2)->first();

        DB::table('books')->insert([
            [
                'title' => 'The Great Gatsby',
                'url_cover' => 'covers/great_gatsby.jpg',
                'author_id' => $author ? $author->id : null,
                'isbn' => '9780743273565',
                'description' => 'A novel set in the Roaring Twenties, exploring themes of decadence and excess.',
                'published_date' => '1925-04-10',
                'category_id' => 1, // Assuming category ID 1 is Fiction
            ],
            [
                'title' => 'A Brief History of Time',
                'url_cover' => 'covers/brief_history_time.jpg',
                'author_id' => $author ? $author->id : null,
                'isbn' => '9780553380163',
                'description' => 'An overview of cosmology from the Big Bang to black holes.',
                'published_date' => '1988-04-01',
                'category_id' => 3, // Assuming category ID 3 is Science
            ],
        ]);
    }
}
