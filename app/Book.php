<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Read;

class Book extends Model
{
    protected $fillable = ['title', 'url_cover','status', 'author_id', 'isbn', 'description', 'published_date', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function chapters()
    {
        return $this->hasMany(\App\Chapter::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reads()
    {
        return $this->hasMany(Read::class, 'book_id');
    }
}
