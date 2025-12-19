<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['first_name', 'last_name', 'last_book_title'];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
