<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'year'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
