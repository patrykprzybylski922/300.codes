<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// public
Route::get('books', [BookController::class, 'index']);
Route::get('books/{book}', [BookController::class, 'show']);
Route::delete('books/{book}', [BookController::class, 'destroy']);

Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{author}', [AuthorController::class, 'show']);
Route::post('authors', [AuthorController::class, 'store']);

// auth
Route::post('login', [AuthController::class, 'login']);

// 🔐 protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('books', [BookController::class, 'store']);
});
