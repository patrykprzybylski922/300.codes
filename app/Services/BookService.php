<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Jobs\UpdateAuthorLastBookTitle;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function paginateWithAuthors(int $perPage = 15): LengthAwarePaginator
    {
        return Book::with('authors')->paginate($perPage);
    }

    public function findWithAuthors(Book $book): Book
    {
        return $book->load('authors');
    }

    public function create(array $data): Book
    {
        return DB::transaction(function () use ($data) {

            $book = Book::create($data);
            $book->authors()->sync($data['authors']);

            // Job after save data
            UpdateAuthorLastBookTitle::dispatch($book->id);

            return $this->findWithAuthors($book);
        });
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);

        if (array_key_exists('authors', $data)) {
            $book->authors()->sync($data['authors']);
        }

        return $this->findWithAuthors($book);
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }
}
