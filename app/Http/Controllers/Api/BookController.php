<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;

class BookController extends Controller
{
    public function __construct(
        private BookService $service
    ) {}

    public function index()
    {
        return BookResource::collection(
            $this->service->paginateWithAuthors()
        );
    }

    public function show(Book $book)
    {
        return new BookResource(
            $this->service->findWithAuthors($book)
        );
    }

    public function store(StoreBookRequest $request)
    {
        return new BookResource(
            $this->service->create($request->validated())
        );
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        return new BookResource(
            $this->service->update($book, $request->validated())
        );
    }

    public function destroy(Book $book)
    {
        $this->service->delete($book);

        return response()->noContent();
    }
}
