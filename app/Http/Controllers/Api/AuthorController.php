<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\AuthorService;
use App\Http\Requests\Author\StoreAuthorRequest;

class AuthorController extends Controller
{
    public function __construct(
        private AuthorService $service
    ) {}

    public function index()
    {
        return AuthorResource::collection(
            $this->service->paginateWithBooks()
        );
    }

    public function show(Author $author)
    {
        return new AuthorResource(
            $this->service->findWithBooks($author)
        );
    }

    public function store(StoreAuthorRequest $request)
    {
        return new AuthorResource(
            $this->service->create($request->validated())
        );
    }
}
