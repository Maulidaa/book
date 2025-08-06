<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['title', 'book_id', 'content'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
