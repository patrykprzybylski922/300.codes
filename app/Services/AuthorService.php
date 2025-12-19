<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function paginateWithBooks(int $perPage = 15)
    {
        return Author::with('books')->paginate($perPage);
    }

    public function findWithBooks(Author $author): Author
    {
        return $author->load('books');
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }
}
