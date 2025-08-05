<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', 'description', 'published_date', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
