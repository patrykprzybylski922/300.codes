<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorService
{
    public function paginateWithBooks(
        int $perPage = 15,
        ?string $search = null
    ): LengthAwarePaginator
    {
        $query = Author::query()
            ->with('books');

        if ($search) {
            $query->whereHas('books', function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
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
