<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['title', 'book_id', 'content', 'chapter_cover', 'status'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'chapter_id');
    }

    public function reader()
    {
        return $this->hasMany(Read::class, 'chapter_id');
    }
}
